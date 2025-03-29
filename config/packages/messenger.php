<?php

declare(strict_types=1);

use App\Message as AppMessages;
use Symfony\Component\Mailer\Messenger\SendEmailMessage;
use Symfony\Component\Notifier\Message\ChatMessage;
use Symfony\Component\Notifier\Message\SmsMessage;
use Symfony\Config\FrameworkConfig;

use function Symfony\Component\DependencyInjection\Loader\Configurator\env;

return static function (FrameworkConfig $framework) {
    $messenger = $framework->messenger();

    $messenger->serializer()
        ->defaultSerializer('messenger.transport.symfony_serializer')
        ->symfonySerializer()
        ->format('json');

    $messenger->failureTransport('failed');

    $asyncTransport = $messenger->transport('async')
        ->dsn(env('MESSENGER_TRANSPORT_DSN'))
        // temp not using json
        ->serializer('messenger.transport.native_php_serializer')
        ->options([
            'use_notify' => true,
            'check_delayed_interval' => 60000,
        ])
        ->retryStrategy()
        ->maxRetries(3)
        ->multiplier(2);

    // this transport is specially for sending posts to telegram with custom retry strategy when rate limit was reached
    $postTransport = $messenger->transport('posts')
        ->dsn(env('MESSENGER_TRANSPORT_DSN'))
        // temp not using json
        ->serializer('messenger.transport.native_php_serializer')
        ->options([
            'use_notify' => true,
            'check_delayed_interval' => 60000,
        ])
        ->retryStrategy()
        ->delay(60000)
        ->multiplier(1)
        ->maxRetries(3);

    $messenger
        ->transport('failed')
        ->dsn('doctrine://default?queue_name=failed');

    $messenger->defaultBus('command.bus');

    // command bus
    $commandBus = $messenger->bus('command.bus');
    $commandBus->middleware()->id('validation');
    $commandBus->middleware()->id('doctrine_transaction');

    // query bus
    $queryBus = $framework->messenger()->bus('query.bus');
    $queryBus->middleware()->id('validation');

    // event bus
    $eventBus = $framework->messenger()->bus('event.bus');
    $eventBus->defaultMiddleware()
        ->enabled(true)
        // set "allowNoHandlers" to true (default is false) to allow having
        // no handler configured for this bus without throwing an exception
        ->allowNoHandlers(false)
        // set "allowNoSenders" to false (default is true) to throw an exception
        // if no sender is configured for this bus
        ->allowNoSenders(true)
    ;
    $eventBus->middleware()->id('validation');

    $messenger->routing(SendEmailMessage::class)->senders(['async']);
    $messenger->routing(ChatMessage::class)->senders(['async']);
    $messenger->routing(SmsMessage::class)->senders(['async']);
    $messenger->routing(AppMessages\CreateFeedMessage::class)->senders(['async']);
    $messenger->routing(AppMessages\SendPostMessage::class)->senders(['posts']);
    $messenger->routing(AppMessages\AddFeedChatMessage::class)->senders(['async']);
};

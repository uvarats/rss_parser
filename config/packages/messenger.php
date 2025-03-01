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

    $messenger->failureTransport('failed');

    $asyncTransport = $messenger->transport('async');
    $asyncTransport
        ->dsn(env('MESSENGER_TRANSPORT_DSN'))
        ->options([
            'use_notify' => true,
            'check_delayed_interval' => 60000,
        ]);

    $asyncTransport->retryStrategy()->maxRetries(3)->multiplier(2);

    $messenger
        ->transport('failed')
        ->dsn('doctrine://default?queue_name=failed');

    $messenger->defaultBus('messenger.bus.default');

    $bus = $messenger->bus('messenger.bus.default');
    $bus->middleware()->id('validation');

    $messenger->routing(SendEmailMessage::class)->senders(['async']);
    $messenger->routing(ChatMessage::class)->senders(['async']);
    $messenger->routing(SmsMessage::class)->senders(['async']);
    $messenger->routing(AppMessages\CreateFeedMessage::class)->senders(['async']);
};

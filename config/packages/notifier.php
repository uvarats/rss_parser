<?php

declare(strict_types=1);

use Symfony\Config\FrameworkConfig;

use function Symfony\Component\DependencyInjection\Loader\Configurator\env;

return static function (FrameworkConfig $framework, string $env) {
    $notifier = $framework->notifier();

    $notifier->chatterTransport('telegram', env('TELEGRAM_DSN'));
    $notifier->messageBus(false);

    $notifier->channelPolicy('urgent', ['email']);
    $notifier->channelPolicy('high', ['email']);
    $notifier->channelPolicy('medium', ['email']);
    $notifier->channelPolicy('low', ['email']);

    $notifier->adminRecipient()->email('admin@example.com');
};
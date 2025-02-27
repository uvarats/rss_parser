<?php

declare(strict_types=1);

// config/services.php
namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use App\Factory\TelegramApiFactory;
use App\ValueObjects\TelegramConfig;
use Vjik\TelegramBot\Api\TelegramBotApi;

return function(ContainerConfigurator $container): void {
    $container->parameters()
        ->set('telegram.bot.token', env('TELEGRAM_BOT_TOKEN')->string());

    // default configuration for services in *this* file
    $services = $container->services()
        ->defaults()
        ->autowire()      // Automatically injects dependencies in your services.
        ->autoconfigure() // Automatically registers your services as commands, event subscribers, etc.
    ;

    // makes classes in src/ available to be used as services
    // this creates a service per class whose id is the fully-qualified class name
    $services->load('App\\', '../src/')
        ->exclude('../src/{DependencyInjection,Entity,Kernel.php}');

    // order is important in this file because service definitions
    // always *replace* previous ones; add your own service configuration below

    $services->set(TelegramConfig::class)
        ->arg('$botToken', param('telegram.bot.token'));

    $services->set(TelegramBotApi::class)
        ->factory([service(TelegramApiFactory::class), 'make']);
};
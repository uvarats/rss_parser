<?php

declare(strict_types=1);

namespace App\Factory;

use App\ValueObjects\TelegramConfig;
use Psr\Log\LoggerInterface;
use Vjik\TelegramBot\Api\TelegramBotApi;

class TelegramApiFactory
{
    public function __construct(
        private readonly TelegramConfig $config,
        private readonly LoggerInterface $logger,
    ) {}

    public function make(): TelegramBotApi
    {
        $token = $this->config->botToken;

        return new TelegramBotApi(
            token: $token,
            logger: $this->logger,
        );
    }
}

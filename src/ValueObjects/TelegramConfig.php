<?php

declare(strict_types=1);

namespace App\ValueObjects;

final readonly class TelegramConfig
{
    public function __construct(
        public string $botToken,
    ) {}
}

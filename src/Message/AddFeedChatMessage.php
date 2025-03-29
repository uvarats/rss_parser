<?php

namespace App\Message;

final readonly class AddFeedChatMessage
{
    public function __construct(
        public int $feedId,
        public int $externalChatId,
        public int $refreshInterval,
    ) {}
}

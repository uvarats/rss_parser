<?php

namespace App\Message;

use App\ValueObjects\PostData;

final readonly class SendPostMessage
{
    public function __construct(
        public int $chatId,
        public PostData $data,
    ) {}
}

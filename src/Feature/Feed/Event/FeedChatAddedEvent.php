<?php

declare(strict_types=1);

namespace App\Feature\Feed\Event;

use App\Entity\FeedChat;

class FeedChatAddedEvent
{
    public function __construct(
        public readonly FeedChat $chat,
    ) {}
}

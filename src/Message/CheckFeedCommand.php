<?php

namespace App\Message;

final readonly class CheckFeedCommand
{
    public function __construct(
        public int $feedId,
    ) {}
}

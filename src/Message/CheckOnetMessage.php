<?php

declare(strict_types=1);

namespace App\Message;

final readonly class CheckOnetMessage
{
    public function __construct(
        public ?\DateTimeImmutable $checkAfter = null,
    ) {}
}

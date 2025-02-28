<?php

declare(strict_types=1);

namespace App\Interface;

use App\Collection\PostCollection;

interface SourceInterface
{
    public function getIdentifier(): string;
    public function getPostsAfter(\DateTimeImmutable $date): PostCollection;
}

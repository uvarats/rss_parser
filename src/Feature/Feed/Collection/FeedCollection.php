<?php

declare(strict_types=1);

namespace App\Feature\Feed\Collection;

use App\Collection\Collection;
use App\Entity\Feed;

/**
 * @extends Collection<Feed>
 */
class FeedCollection extends Collection
{
    #[\Override]
    public function getType(): string
    {
        return Feed::class;
    }
}

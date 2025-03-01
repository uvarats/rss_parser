<?php

declare(strict_types=1);

namespace App\Feature\Feed\Interface;

use App\Feature\Feed\Collection\FeedCollection;

interface FeedResolverInterface
{
    public function getActive(): FeedCollection;
}

<?php

declare(strict_types=1);

namespace App\Feature\Feed\Service;

use App\Feature\Feed\Collection\FeedCollection;
use App\Feature\Feed\Interface\FeedResolverInterface;
use App\Feature\Feed\Repository\FeedRepository;

final readonly class FeedResolver implements FeedResolverInterface
{
    public function __construct(
        private FeedRepository $feedRepository,
    ) {}

    #[\Override]
    public function getActive(): FeedCollection
    {
        $feeds = $this->feedRepository->findActive();

        return new FeedCollection($feeds);
    }
}

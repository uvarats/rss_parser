<?php

declare(strict_types=1);

namespace App\Service\Adapters;

use App\Collection\PostCollection;
use App\Interface\SourceInterface;

class OnetFeed implements SourceInterface
{
    private const string FEED_ENDPOINT = 'https://wiadomosci.onet.pl/.feed';

    public function __construct(
        private readonly GeneralFeedAdapter $generalFeedAdapter,
    ) {}


    public function getIdentifier(): string
    {
        return self::FEED_ENDPOINT;
    }

    public function getPostsAfter(\DateTimeImmutable $date): PostCollection
    {
        return $this->generalFeedAdapter->getPostsAfter(self::FEED_ENDPOINT, $date);
    }
}

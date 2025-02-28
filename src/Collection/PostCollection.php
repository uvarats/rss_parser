<?php

declare(strict_types=1);

namespace App\Collection;

use App\ValueObjects\PostData;

/**
 * @extends Collection<PostData>
 */
final class PostCollection extends Collection
{
    #[\Override]
    public function getType(): string
    {
        return PostData::class;
    }

    public function orderByCreationDate(): PostCollection
    {
        $sortedPosts = $this->sort('getCreatedAt');

        assert($sortedPosts instanceof PostCollection);

        return $sortedPosts;
    }

    public function afterDate(\DateTimeImmutable $dateTime): PostCollection
    {
        $collection = $this->filter(function (PostData $data) use ($dateTime) {
            return $data->getCreatedAt() > $dateTime;
        });

        assert($collection instanceof PostCollection);

        return $collection;
    }
}

<?php

declare(strict_types=1);

namespace App\Service\Adapters;

use App\Collection\PostCollection;
use App\ValueObjects\PostData;
use Laminas\Feed\Reader\Entry\Atom;
use Laminas\Feed\Reader\Reader;
use League\Uri\Uri;

class GeneralFeedAdapter
{
    public function getPostsAfter(string $feedUrl, \DateTimeImmutable $date): PostCollection
    {
        return $this->getFeed()
            ->afterDate($date)
            ->orderByCreationDate();
    }

    private function getFeed(): PostCollection
    {
        $channel = Reader::import('https://wiadomosci.onet.pl/.feed');

        $posts = new PostCollection();

        /** @var Atom $item */
        foreach ($channel as $item) {
            $enclosure = $item->getEnclosure();

            if ($enclosure instanceof \stdClass && property_exists($enclosure, 'url')) {
                $enclosure = $enclosure->url;
            } elseif(!is_string($enclosure)) {
                $enclosure = null;
            }

            $description = html_entity_decode(strip_tags($item->getContent()));
            // telegram reserved parenthesis for some reason
            $description = str_replace(['(', ')'], ['\(', '\)'], $description);

            $posts[] = new PostData(
                id: $item->getId(),
                title: $item->getTitle(),
                link: $item->getPermalink(),
                createdAt: \DateTimeImmutable::createFromMutable($item->getDateCreated()),
                updatedAt: \DateTimeImmutable::createFromMutable($item->getDateModified()),
                enclosureLink: Uri::new($enclosure)->withScheme('https')->toString(),
                description: $description,
            );
        }

        return $posts;
    }
}

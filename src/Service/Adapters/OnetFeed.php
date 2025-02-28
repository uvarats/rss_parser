<?php

declare(strict_types=1);

namespace App\Service\Adapters;

use App\Collection\PostCollection;
use App\Interface\SourceInterface;
use App\ValueObjects\PostData;
use Laminas\Feed\Reader\Entry\Atom;
use Laminas\Feed\Reader\Reader;
use League\Uri\Uri;

class OnetFeed implements SourceInterface
{
    private const string FEED_ENDPOINT = 'https://wiadomosci.onet.pl/.feed';


    public function getIdentifier(): string
    {
        return self::FEED_ENDPOINT;
    }

    public function getPostsAfter(\DateTimeImmutable $date): PostCollection
    {
        return $this->getFeed()
            ->afterDate($date)
            ->orderByCreationDate();
    }

    // maybe factory? but then I would couple app more with library
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

            $posts[] = new PostData(
                id: $item->getId(),
                title: $item->getTitle(),
                link: $item->getPermalink(),
                createdAt: \DateTimeImmutable::createFromMutable($item->getDateCreated()),
                updatedAt: \DateTimeImmutable::createFromMutable($item->getDateModified()),
                enclosureLink: Uri::new($enclosure)->withScheme('https')->toString(),
                description: html_entity_decode(strip_tags($item->getContent())),
            );
        }

        return $posts;
    }
}

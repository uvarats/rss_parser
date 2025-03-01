<?php

namespace App\MessageHandler;

use App\Entity\Feed;
use App\Message\CreateFeedMessage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class CreateFeedMessageHandler
{
    public function __construct(
        private EntityManagerInterface $em,
    ) {}

    public function __invoke(CreateFeedMessage $message): void
    {
        $feed = Feed::make(
            name: $message->name,
            url: $message->url,
            type: $message->type,
        );

        $this->em->persist($feed);
        $this->em->flush();
    }
}

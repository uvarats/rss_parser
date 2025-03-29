<?php

namespace App\MessageHandler;

use App\Entity\FeedChat;
use App\Feature\Feed\Event\FeedChatAddedEvent;
use App\Feature\Feed\Repository\FeedRepository;
use App\Message\AddFeedChatMessage;
use Doctrine\ORM\EntityManagerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class AddFeedChatMessageHandler
{
    public function __construct(
        private FeedRepository $feedRepository,
        private LoggerInterface $logger,
        private EntityManagerInterface $entityManager,
        private EventDispatcherInterface $eventDispatcher,
    ) {}

    public function __invoke(AddFeedChatMessage $message): void
    {
        $feedId = $message->feedId;
        $feed = $this->feedRepository->findOneBy(['id' => $feedId]);

        if ($feed === null) {
            $this->logger->warning('Failed to add feed chat: feed with id ' . $feedId . ' not found');

            return;
        }

        $feedChat = FeedChat::make(
            chatId: $message->externalChatId,
            feed: $feed,
            refreshInterval: $message->refreshInterval,
        );

        $this->entityManager->persist($feedChat);
        $this->entityManager->flush();

        $this->eventDispatcher->dispatch(new FeedChatAddedEvent($feedChat));
    }
}

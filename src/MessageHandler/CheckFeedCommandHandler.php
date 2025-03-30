<?php

namespace App\MessageHandler;

use App\Feature\Feed\Repository\FeedChatRepository;
use App\Feature\Feed\Repository\FeedRepository;
use App\Feature\Feed\ValueObject\FeedId;
use App\Message\CheckFeedCommand;
use App\Message\SendPostMessage;
use App\Service\Adapters\GeneralFeedAdapter;
use Cake\Chronos\Chronos;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler]
final readonly class CheckFeedCommandHandler
{
    public function __construct(
        private FeedRepository $feedRepository,
        private GeneralFeedAdapter $feedAdapter,
        private FeedChatRepository $feedChatRepository,
        private MessageBusInterface $bus,
        private EntityManagerInterface $entityManager,
    ) {}

    public function __invoke(CheckFeedCommand $message): void
    {
        $feed = $this->feedRepository->findOneBy(['id' => $message->feedId]);

        if ($feed === null) {
            return;
        }

        $feedUrl = $feed->getUrl();
        $postsAfterDate = $feed->getLastCheckAt() ?? Chronos::now()->subMinutes(60);
        $posts = $this->feedAdapter->getPostsAfter($feedUrl, $postsAfterDate);

        $chats = $this->feedChatRepository->findActiveByFeedId(
            feedId: FeedId::fromInt($feed->getId()),
        );

        foreach ($posts as $post) {
            foreach ($chats as $feedChat) {
                $chatId = $feedChat->getChatId() ?? throw new \LogicException();

                $this->bus->dispatch(new SendPostMessage((int)$chatId, $post));
            }

            usleep(50000);
        }

        $feed->touchLastCheck();
        $this->entityManager->flush();
    }
}

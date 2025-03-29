<?php

namespace App\MessageHandler;

use App\Feature\Feed\Repository\FeedChatRepository;
use App\Feature\Feed\Repository\FeedRepository;
use App\Message\CheckFeedCommand;
use App\Service\Adapters\GeneralFeedAdapter;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class CheckFeedCommandHandler
{
    public function __construct(
        private FeedRepository $feedRepository,
        private GeneralFeedAdapter $feedAdapter,
        private FeedChatRepository $feedChatRepository,
    ) {}

    public function __invoke(CheckFeedCommand $message): void
    {
        $feed = $this->feedRepository->findOneBy(['id' => $message->feedId]);

        if ($feed === null) {
            return;
        }
    }
}

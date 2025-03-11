<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\CheckOnetMessage;
use App\Message\SendPostMessage;
use App\Service\Adapters\OnetFeed;
use Cake\Chronos\Chronos;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler]
final readonly class CheckOnetMessageHandler
{
    public function __construct(
        private OnetFeed $onetFeed,
        private MessageBusInterface $bus,
    ) {}

    public function __invoke(CheckOnetMessage $message): void
    {
        $postsAfter = $message->checkAfter ?? $this->lastFiveMinutes();

        $posts = $this->onetFeed->getPostsAfter($postsAfter);
        $chatId = -1002461478314; // hardcoded, yes

        foreach ($posts as $postData) {
            $this->bus->dispatch(new SendPostMessage($chatId, $postData));
            usleep(100000);
        }
    }

    private function lastFiveMinutes(): \DateTimeImmutable
    {
        return Chronos::now()->subMinutes(5);
    }
}

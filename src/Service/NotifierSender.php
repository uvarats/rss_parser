<?php

declare(strict_types=1);

namespace App\Service;

use App\Interface\TextResolverInterface;
use App\ValueObjects\PostData;
use Symfony\Component\Notifier\Bridge\Telegram\TelegramOptions;
use Symfony\Component\Notifier\ChatterInterface;
use Symfony\Component\Notifier\Message\ChatMessage;

class NotifierSender
{
    public function __construct(
        private readonly ChatterInterface $chatter,
        private readonly TextResolverInterface $textResolver,
    ) {}

    public function send(int $chatId, PostData $postData): void
    {
        $text = sprintf(
            "*%s*\n\n%s\n\n*[%s](%s)*",
            $postData->getTitle(),
            $postData->getDescription(),
            $this->textResolver->getMoreDetailsText(),
            $postData->getLink(),
        );

        $message = new ChatMessage($text);

        $options = new TelegramOptions()
            ->chatId((string)$chatId)
            ->photo($postData->getEnclosureLink());

        $message->options($options);

        $this->chatter->send($message);
    }
}

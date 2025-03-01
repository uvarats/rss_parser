<?php

declare(strict_types=1);

namespace App\Service;

use App\ValueObjects\PostData;
use Symfony\Component\Notifier\Bridge\Telegram\TelegramOptions;
use Symfony\Component\Notifier\ChatterInterface;
use Symfony\Component\Notifier\Message\ChatMessage;

class NotifierSender
{
    private const string MORE_DETAILS_TEXT = 'Więcej szczegółów';

    public function __construct(
        private readonly ChatterInterface $chatter,
    ) {}

    public function send(int $chatId, PostData $postData): void
    {
        $text = sprintf(
            "*%s*\n\n%s\n\n*[%s](%s)*",
            $postData->getTitle(),
            $postData->getDescription(),
            self::MORE_DETAILS_TEXT,
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

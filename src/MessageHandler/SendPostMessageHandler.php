<?php

namespace App\MessageHandler;

use App\Message\SendPostMessage;
use App\Service\NotifierSender;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class SendPostMessageHandler
{
    public function __construct(
        private NotifierSender $notifierSender,
    ) {}

    public function __invoke(SendPostMessage $message): void
    {
        $chatId = $message->chatId;
        $postData = $message->data;

        $this->notifierSender->send($chatId, $postData);
    }
}

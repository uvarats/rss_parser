<?php

declare(strict_types=1);

namespace App\Service;

use App\ValueObjects\PostData;
use Vjik\TelegramBot\Api\Constant\MessageEntityType;
use Vjik\TelegramBot\Api\TelegramBotApi;
use Vjik\TelegramBot\Api\Type\MessageEntity;

class TelegramSender
{
    // todo: made something with this
    private const string MORE_DETAILS_TEXT = 'Więcej szczegółów';

    public function __construct(
        private readonly TelegramBotApi $api,
    ) {}

    public function send(int $chatId, PostData $data): void
    {
        $composedMessage = $data->getTitle() . PHP_EOL . PHP_EOL . $data->getDescription() . PHP_EOL . PHP_EOL . self::MORE_DETAILS_TEXT;

        $this->api->sendPhoto(
            chatId: $chatId,
            photo: $data->getEnclosureLink(),
            caption: $composedMessage,
            captionEntities: [
                new MessageEntity(
                    type: MessageEntityType::BOLD,
                    offset: mb_stripos($composedMessage, $data->getTitle()),
                    length: mb_strlen($data->getTitle()),
                ),
                new MessageEntity(
                    type: MessageEntityType::BOLD,
                    offset: mb_stripos($composedMessage, self::MORE_DETAILS_TEXT),
                    length: mb_strlen(self::MORE_DETAILS_TEXT),
                ),
                new MessageEntity(
                    type: MessageEntityType::TEXT_LINK,
                    offset: mb_stripos($composedMessage, self::MORE_DETAILS_TEXT),
                    length: mb_strlen(self::MORE_DETAILS_TEXT),
                    url: $data->getLink(),
                ),
            ],
        );
    }
}

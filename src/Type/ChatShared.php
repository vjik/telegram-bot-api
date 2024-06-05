<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#chatshared
 */
final readonly class ChatShared
{
    /**
     * @param PhotoSize[]|null $photo
     */
    public function __construct(
        public int $requestId,
        public int $chatId,
        public ?string $title = null,
        public ?string $username = null,
        public ?array $photo = null,
    ) {
    }

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            ValueHelper::getInteger($result, 'request_id'),
            ValueHelper::getInteger($result, 'chat_id'),
            ValueHelper::getStringOrNull($result, 'title'),
            ValueHelper::getStringOrNull($result, 'username'),
            ValueHelper::getArrayOfPhotoSizesOrNull($result, 'photo'),
        );
    }
}

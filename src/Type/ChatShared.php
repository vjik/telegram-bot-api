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

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            ValueHelper::getInteger($result, 'request_id', $raw),
            ValueHelper::getInteger($result, 'chat_id', $raw),
            ValueHelper::getStringOrNull($result, 'title', $raw),
            ValueHelper::getStringOrNull($result, 'username', $raw),
            ValueHelper::getArrayOfPhotoSizesOrNull($result, 'photo', $raw),
        );
    }
}

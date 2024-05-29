<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

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
        public ?string $title,
        public ?string $username,
        public ?array $photo,
    ) {
    }
}

<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#chat
 */
final readonly class Chat
{
    public function __construct(
        public int $id,
        public string $type,
        public ?string $title,
        public ?string $username,
        public ?string $firstName,
        public ?string $lastName,
        public ?true $isForum,
    ) {
    }
}

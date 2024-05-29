<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#messageentity
 */
final readonly class MessageEntity
{
    public function __construct(
        public string $type,
        public int $offset,
        public int $length,
        public ?string $url,
        public ?User $user,
        public ?string $language,
        public ?string $customEmojiId,
    ) {
    }
}

<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

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

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            ValueHelper::getString($result, 'type'),
            ValueHelper::getInteger($result, 'offset'),
            ValueHelper::getInteger($result, 'length'),
            ValueHelper::getStringOrNull($result, 'url'),
            array_key_exists('user', $result)
                ? User::fromTelegramResult($result['user'])
                : null,
            ValueHelper::getStringOrNull($result, 'language'),
            ValueHelper::getStringOrNull($result, 'custom_emoji_id'),
        );
    }
}

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
        public ?string $url = null,
        public ?User $user = null,
        public ?string $language = null,
        public ?string $customEmojiId = null,
    ) {
    }

    public function toRequestArray(): array
    {
        return array_filter(
            [
                'type' => $this->type,
                'offset' => $this->offset,
                'length' => $this->length,
                'url' => $this->url,
                'user' => $this->user?->toRequestArray(),
                'language' => $this->language,
                'custom_emoji_id' => $this->customEmojiId,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
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

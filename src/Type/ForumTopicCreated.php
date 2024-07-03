<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#forumtopiccreated
 */
final readonly class ForumTopicCreated
{
    public function __construct(
        public string $name,
        public int $iconColor,
        public ?string $iconCustomEmojiId = null,
    ) {
    }

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            ValueHelper::getString($result, 'name', $raw),
            ValueHelper::getInteger($result, 'icon_color', $raw),
            ValueHelper::getStringOrNull($result, 'icon_custom_emoji_id', $raw),
        );
    }
}

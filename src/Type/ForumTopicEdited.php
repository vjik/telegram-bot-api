<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#forumtopicedited
 */
final readonly class ForumTopicEdited
{
    public function __construct(
        public ?string $name = null,
        public ?string $iconCustomEmojiId = null,
    ) {
    }

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            ValueHelper::getStringOrNull($result, 'name', $raw),
            ValueHelper::getStringOrNull($result, 'icon_custom_emoji_id', $raw),
        );
    }
}

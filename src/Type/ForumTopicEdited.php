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
        public ?string $name,
        public ?string $iconCustomEmojiId,
    ) {
    }

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            ValueHelper::getStringOrNull($result, 'name'),
            ValueHelper::getStringOrNull($result, 'icon_custom_emoji_id'),
        );
    }
}

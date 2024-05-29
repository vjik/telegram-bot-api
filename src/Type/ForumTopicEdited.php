<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

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
}

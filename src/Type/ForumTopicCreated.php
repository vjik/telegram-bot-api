<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#forumtopiccreated
 *
 * @api
 */
final readonly class ForumTopicCreated
{
    public function __construct(
        public string $name,
        public int $iconColor,
        public ?string $iconCustomEmojiId = null,
    ) {}
}

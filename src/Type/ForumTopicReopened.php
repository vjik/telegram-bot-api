<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#forumtopicreopened
 */
final readonly class ForumTopicReopened
{
    public static function fromTelegramResult(mixed $result): self
    {
        return new self();
    }
}

<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#forumtopicclosed
 */
final readonly class ForumTopicClosed
{
    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        return new self();
    }
}

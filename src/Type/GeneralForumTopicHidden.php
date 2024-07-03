<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#generalforumtopichidden
 */
final readonly class GeneralForumTopicHidden
{
    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        return new self();
    }
}

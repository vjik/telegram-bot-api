<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#generalforumtopicunhidden
 */
final readonly class GeneralForumTopicUnhidden
{
    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        return new self();
    }
}

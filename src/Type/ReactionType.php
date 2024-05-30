<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#reactiontype
 */
interface ReactionType
{
    public function getType(): string;
}

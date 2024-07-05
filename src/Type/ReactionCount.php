<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#reactioncount
 */
final readonly class ReactionCount
{
    public function __construct(
        public ReactionType $type,
        public int $totalCount,
    ) {
    }
}

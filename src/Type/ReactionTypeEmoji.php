<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#reactiontypeemoji
 */
final readonly class ReactionTypeEmoji implements ReactionType
{
    public function __construct(
        public string $emoji,
    ) {
    }

    public function getType(): string
    {
        return 'emoji';
    }
}

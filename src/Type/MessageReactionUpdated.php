<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use DateTimeImmutable;

/**
 * @see https://core.telegram.org/bots/api#messagereactionupdated
 */
final readonly class MessageReactionUpdated
{
    /**
     * @param ReactionType[] $oldReaction
     * @param ReactionType[] $newReaction
     */
    public function __construct(
        public Chat $chat,
        public int $messageId,
        public ?User $user,
        public ?Chat $actorChat,
        public DateTimeImmutable $date,
        public array $oldReaction,
        public array $newReaction,
    ) {
    }
}

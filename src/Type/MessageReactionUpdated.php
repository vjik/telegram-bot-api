<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use DateTimeImmutable;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ArrayOfValueProcessors;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ReactionTypeValue;

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
        public DateTimeImmutable $date,
        #[ArrayOfValueProcessors(ReactionTypeValue::class)]
        public array $oldReaction,
        #[ArrayOfValueProcessors(ReactionTypeValue::class)]
        public array $newReaction,
        public ?User $user = null,
        public ?Chat $actorChat = null,
    ) {
    }
}

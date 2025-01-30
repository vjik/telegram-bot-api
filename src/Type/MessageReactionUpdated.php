<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use DateTimeImmutable;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ArrayMap;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ReactionTypeValue;

/**
 * @see https://core.telegram.org/bots/api#messagereactionupdated
 *
 * @api
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
        #[ArrayMap(ReactionTypeValue::class)]
        public array $oldReaction,
        #[ArrayMap(ReactionTypeValue::class)]
        public array $newReaction,
        public ?User $user = null,
        public ?Chat $actorChat = null,
    ) {}
}

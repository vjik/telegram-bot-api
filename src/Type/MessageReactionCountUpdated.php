<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use DateTimeImmutable;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ArrayOfObjectsValue;

/**
 * @see https://core.telegram.org/bots/api#messagereactioncountupdated
 */
final readonly class MessageReactionCountUpdated
{
    /**
     * @param ReactionCount[] $reactions
     */
    public function __construct(
        public Chat $chat,
        public int $messageId,
        public DateTimeImmutable $date,
        #[ArrayOfObjectsValue(ReactionCount::class)]
        public array $reactions,
    ) {}
}

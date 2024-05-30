<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use DateTimeImmutable;
use Vjik\TelegramBot\Api\ParseResult\NotFoundKeyInResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

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
        public array $reactions,
    ) {
    }

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            array_key_exists('chat', $result)
                ? Chat::fromTelegramResult($result['chat'])
                : throw new NotFoundKeyInResultException('chat'),
            ValueHelper::getInteger($result, 'message_id'),
            ValueHelper::getDateTimeImmutable($result, 'date'),
            ValueHelper::getArrayOfReactionCounts($result, 'reactions'),
        );
    }
}

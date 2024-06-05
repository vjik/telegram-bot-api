<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use DateTimeImmutable;
use Vjik\TelegramBot\Api\ParseResult\NotFoundKeyInResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

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
        public array $oldReaction,
        public array $newReaction,
        public ?User $user = null,
        public ?Chat $actorChat = null,
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
            ValueHelper::getArrayOfReactionTypes($result, 'old_reaction'),
            ValueHelper::getArrayOfReactionTypes($result, 'new_reaction'),
            array_key_exists('user', $result)
                ? User::fromTelegramResult($result['user'])
                : null,
            array_key_exists('actor_chat', $result)
                ? Chat::fromTelegramResult($result['actor_chat'])
                : null,
        );
    }
}

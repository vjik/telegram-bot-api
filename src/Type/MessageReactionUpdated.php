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

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            array_key_exists('chat', $result)
                ? Chat::fromTelegramResult($result['chat'], $raw)
                : throw new NotFoundKeyInResultException('chat', $raw),
            ValueHelper::getInteger($result, 'message_id', $raw),
            ValueHelper::getDateTimeImmutable($result, 'date', $raw),
            ValueHelper::getArrayOfReactionTypes($result, 'old_reaction', $raw),
            ValueHelper::getArrayOfReactionTypes($result, 'new_reaction', $raw),
            array_key_exists('user', $result)
                ? User::fromTelegramResult($result['user'], $raw)
                : null,
            array_key_exists('actor_chat', $result)
                ? Chat::fromTelegramResult($result['actor_chat'], $raw)
                : null,
        );
    }
}

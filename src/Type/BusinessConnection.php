<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use DateTimeImmutable;
use Vjik\TelegramBot\Api\ParseResult\NotFoundKeyInResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#businessconnection
 */
final readonly class BusinessConnection
{
    public function __construct(
        public string $id,
        public User $user,
        public int $userChatId,
        public DateTimeImmutable $date,
        public bool $canReply,
        public bool $isEnabled,
    ) {
    }

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            ValueHelper::getString($result, 'id'),
            array_key_exists('user', $result)
                ? User::fromTelegramResult($result['user'])
                : throw new NotFoundKeyInResultException('user'),
            ValueHelper::getInteger($result, 'user_chat_id'),
            ValueHelper::getDateTimeImmutable($result, 'date'),
            ValueHelper::getBoolean($result, 'can_reply'),
            ValueHelper::getBoolean($result, 'is_enabled'),
        );
    }
}

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

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            ValueHelper::getString($result, 'id', $raw),
            array_key_exists('user', $result)
                ? User::fromTelegramResult($result['user'], $raw)
                : throw new NotFoundKeyInResultException('user', $raw),
            ValueHelper::getInteger($result, 'user_chat_id', $raw),
            ValueHelper::getDateTimeImmutable($result, 'date', $raw),
            ValueHelper::getBoolean($result, 'can_reply', $raw),
            ValueHelper::getBoolean($result, 'is_enabled', $raw),
        );
    }
}

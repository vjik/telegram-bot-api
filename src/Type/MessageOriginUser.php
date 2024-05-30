<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use DateTimeImmutable;
use Vjik\TelegramBot\Api\ParseResult\NotFoundKeyInResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#messageoriginuser
 */
final readonly class MessageOriginUser implements MessageOrigin
{
    public function __construct(
        public DateTimeImmutable $date,
        public User $senderUser,
    ) {
    }

    public function getType(): string
    {
        return 'user';
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            ValueHelper::getDateTimeImmutable($result, 'date'),
            array_key_exists('sender_user', $result)
                ? User::fromTelegramResult($result['sender_user'])
                : throw new NotFoundKeyInResultException('sender_user'),
        );
    }
}

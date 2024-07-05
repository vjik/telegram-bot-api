<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use DateTimeImmutable;

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
}

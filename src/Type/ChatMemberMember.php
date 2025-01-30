<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use DateTimeImmutable;

/**
 * @see https://core.telegram.org/bots/api#chatmembermember
 *
 * @api
 */
final readonly class ChatMemberMember implements ChatMember
{
    public function __construct(
        public User $user,
        public DateTimeImmutable|null $untilDate = null,
    ) {}

    public function getStatus(): string
    {
        return 'member';
    }

    public function getUser(): User
    {
        return $this->user;
    }
}

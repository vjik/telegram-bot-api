<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#chatmembermember
 */
final readonly class ChatMemberMember implements ChatMember
{
    public function __construct(
        public User $user,
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

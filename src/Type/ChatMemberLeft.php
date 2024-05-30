<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#chatmemberleft
 */
final readonly class ChatMemberLeft implements ChatMember
{
    public function __construct(
        public User $user,
    ) {
    }

    public function getStatus(): string
    {
        return 'left';
    }

    public function getUser(): User
    {
        return $this->user;
    }
}

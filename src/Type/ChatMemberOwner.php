<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#chatmemberowner
 */
final readonly class ChatMemberOwner implements ChatMember
{
    public function __construct(
        public User $user,
        public bool $isAnonymous,
        public ?string $customTitle = null,
    ) {}

    public function getStatus(): string
    {
        return 'creator';
    }

    public function getUser(): User
    {
        return $this->user;
    }
}

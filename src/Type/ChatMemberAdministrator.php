<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#chatmemberadministrator
 */
final readonly class ChatMemberAdministrator implements ChatMember
{
    public function __construct(
        public User $user,
        public bool $canBeEdited,
        public bool $isAnonymous,
        public bool $canManageChat,
        public bool $canDeleteMessages,
        public bool $canManageVideoChats,
        public bool $canRestrictMembers,
        public bool $canPromoteMembers,
        public bool $canChangeInfo,
        public bool $canInviteUsers,
        public bool $canPostStories,
        public bool $canEditStories,
        public bool $canDeleteStories,
        public ?bool $canPostMessages,
        public ?bool $canEditMessages,
        public ?bool $canPinMessages,
        public ?bool $canManageTopics,
        public ?string $customTitle,
    ) {
    }

    public function getStatus(): string
    {
        return 'administrator';
    }

    public function getUser(): User
    {
        return $this->user;
    }
}

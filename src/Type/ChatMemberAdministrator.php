<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\NotFoundKeyInResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

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
        public ?bool $canPostMessages = null,
        public ?bool $canEditMessages = null,
        public ?bool $canPinMessages = null,
        public ?bool $canManageTopics = null,
        public ?string $customTitle = null,
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

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            array_key_exists('user', $result)
                ? User::fromTelegramResult($result['user'])
                : throw new NotFoundKeyInResultException('user'),
            ValueHelper::getBoolean($result, 'can_be_edited'),
            ValueHelper::getBoolean($result, 'is_anonymous'),
            ValueHelper::getBoolean($result, 'can_manage_chat'),
            ValueHelper::getBoolean($result, 'can_delete_messages'),
            ValueHelper::getBoolean($result, 'can_manage_video_chats'),
            ValueHelper::getBoolean($result, 'can_restrict_members'),
            ValueHelper::getBoolean($result, 'can_promote_members'),
            ValueHelper::getBoolean($result, 'can_change_info'),
            ValueHelper::getBoolean($result, 'can_invite_users'),
            ValueHelper::getBoolean($result, 'can_post_stories'),
            ValueHelper::getBoolean($result, 'can_edit_stories'),
            ValueHelper::getBoolean($result, 'can_delete_stories'),
            ValueHelper::getBooleanOrNull($result, 'can_post_messages'),
            ValueHelper::getBooleanOrNull($result, 'can_edit_messages'),
            ValueHelper::getBooleanOrNull($result, 'can_pin_messages'),
            ValueHelper::getBooleanOrNull($result, 'can_manage_topics'),
            ValueHelper::getStringOrNull($result, 'custom_title'),
        );
    }
}

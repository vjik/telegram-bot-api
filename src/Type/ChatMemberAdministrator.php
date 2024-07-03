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

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            array_key_exists('user', $result)
                ? User::fromTelegramResult($result['user'], $raw)
                : throw new NotFoundKeyInResultException('user', $raw),
            ValueHelper::getBoolean($result, 'can_be_edited', $raw),
            ValueHelper::getBoolean($result, 'is_anonymous', $raw),
            ValueHelper::getBoolean($result, 'can_manage_chat', $raw),
            ValueHelper::getBoolean($result, 'can_delete_messages', $raw),
            ValueHelper::getBoolean($result, 'can_manage_video_chats', $raw),
            ValueHelper::getBoolean($result, 'can_restrict_members', $raw),
            ValueHelper::getBoolean($result, 'can_promote_members', $raw),
            ValueHelper::getBoolean($result, 'can_change_info', $raw),
            ValueHelper::getBoolean($result, 'can_invite_users', $raw),
            ValueHelper::getBoolean($result, 'can_post_stories', $raw),
            ValueHelper::getBoolean($result, 'can_edit_stories', $raw),
            ValueHelper::getBoolean($result, 'can_delete_stories', $raw),
            ValueHelper::getBooleanOrNull($result, 'can_post_messages', $raw),
            ValueHelper::getBooleanOrNull($result, 'can_edit_messages', $raw),
            ValueHelper::getBooleanOrNull($result, 'can_pin_messages', $raw),
            ValueHelper::getBooleanOrNull($result, 'can_manage_topics', $raw),
            ValueHelper::getStringOrNull($result, 'custom_title', $raw),
        );
    }
}

<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#chatadministratorrights
 */
final readonly class ChatAdministratorRights
{
    public function __construct(
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
    ) {
    }

    public function toRequestArray(): array
    {
        return array_filter(
            [
                'is_anonymous' => $this->isAnonymous,
                'can_manage_chat' => $this->canManageChat,
                'can_delete_messages' => $this->canDeleteMessages,
                'can_manage_video_chats' => $this->canManageVideoChats,
                'can_restrict_members' => $this->canRestrictMembers,
                'can_promote_members' => $this->canPromoteMembers,
                'can_change_info' => $this->canChangeInfo,
                'can_invite_users' => $this->canInviteUsers,
                'can_post_stories' => $this->canPostStories,
                'can_edit_stories' => $this->canEditStories,
                'can_delete_stories' => $this->canDeleteStories,
                'can_post_messages' => $this->canPostMessages,
                'can_edit_messages' => $this->canEditMessages,
                'can_pin_messages' => $this->canPinMessages,
                'can_manage_topics' => $this->canManageTopics,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
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
        );
    }
}

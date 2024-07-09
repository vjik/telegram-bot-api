<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\TrueValue;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\TelegramRequestWithResultPreparingInterface;

/**
 * @see https://core.telegram.org/bots/api#promotechatmember
 */
final readonly class PromoteChatMember implements TelegramRequestWithResultPreparingInterface
{
    public function __construct(
        private int|string $chatId,
        private int $userId,
        private ?bool $isAnonymous = null,
        private ?bool $canManageChat = null,
        private ?bool $canDeleteMessages = null,
        private ?bool $canManageVideoChats = null,
        private ?bool $canRestrictMembers = null,
        private ?bool $canPromoteMembers = null,
        private ?bool $canChangeInfo = null,
        private ?bool $canInviteUsers = null,
        private ?bool $canPostStories = null,
        private ?bool $canEditStories = null,
        private ?bool $canDeleteStories = null,
        private ?bool $canPostMessages = null,
        private ?bool $canEditMessages = null,
        private ?bool $canPinMessages = null,
        private ?bool $canManageTopics = null,
    ) {
    }

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'promoteChatMember';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'chat_id' => $this->chatId,
                'user_id' => $this->userId,
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

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}

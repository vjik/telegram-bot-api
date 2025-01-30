<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use DateTimeImmutable;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ChatMemberUntilDateValue;

/**
 * @see https://core.telegram.org/bots/api#chatmemberrestricted
 *
 * @api
 */
final readonly class ChatMemberRestricted implements ChatMember
{
    public function __construct(
        public User $user,
        public bool $isMember,
        public bool $canSendMessages,
        public bool $canSendAudios,
        public bool $canSendDocuments,
        public bool $canSendPhotos,
        public bool $canSendVideos,
        public bool $canSendVideoNotes,
        public bool $canSendVoiceNotes,
        public bool $canSendPolls,
        public bool $canSendOtherMessages,
        public bool $canAddWebPagePreviews,
        public bool $canChangeInfo,
        public bool $canInviteUsers,
        public bool $canPinMessages,
        public bool $canManageTopics,
        #[ChatMemberUntilDateValue]
        public DateTimeImmutable|false $untilDate,
    ) {}

    public function getStatus(): string
    {
        return 'restricted';
    }

    public function getUser(): User
    {
        return $this->user;
    }
}

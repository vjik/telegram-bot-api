<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use DateTimeImmutable;
use Vjik\TelegramBot\Api\ParseResult\NotFoundKeyInResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#chatmemberrestricted
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
        public DateTimeImmutable|false $untilDate,
    ) {
    }

    public function getStatus(): string
    {
        return 'restricted';
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);

        $untilDate = ValueHelper::getInteger($result, 'until_date');
        $untilDate = $untilDate === 0
            ? false
            : (new DateTimeImmutable())->setTimestamp($untilDate);

        return new self(
            array_key_exists('user', $result)
                ? User::fromTelegramResult($result['user'])
                : throw new NotFoundKeyInResultException('user'),
            ValueHelper::getBoolean($result, 'is_member'),
            ValueHelper::getBoolean($result, 'can_send_messages'),
            ValueHelper::getBoolean($result, 'can_send_audios'),
            ValueHelper::getBoolean($result, 'can_send_documents'),
            ValueHelper::getBoolean($result, 'can_send_photos'),
            ValueHelper::getBoolean($result, 'can_send_videos'),
            ValueHelper::getBoolean($result, 'can_send_video_notes'),
            ValueHelper::getBoolean($result, 'can_send_voice_notes'),
            ValueHelper::getBoolean($result, 'can_send_polls'),
            ValueHelper::getBoolean($result, 'can_send_other_messages'),
            ValueHelper::getBoolean($result, 'can_add_web_page_previews'),
            ValueHelper::getBoolean($result, 'can_change_info'),
            ValueHelper::getBoolean($result, 'can_invite_users'),
            ValueHelper::getBoolean($result, 'can_pin_messages'),
            ValueHelper::getBoolean($result, 'can_manage_topics'),
            $untilDate,
        );
    }
}

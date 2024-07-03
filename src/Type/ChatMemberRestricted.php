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

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);

        $untilDate = ValueHelper::getInteger($result, 'until_date', $raw);
        $untilDate = $untilDate === 0
            ? false
            : (new DateTimeImmutable())->setTimestamp($untilDate);

        return new self(
            array_key_exists('user', $result)
                ? User::fromTelegramResult($result['user'], $raw)
                : throw new NotFoundKeyInResultException('user', $raw),
            ValueHelper::getBoolean($result, 'is_member', $raw),
            ValueHelper::getBoolean($result, 'can_send_messages', $raw),
            ValueHelper::getBoolean($result, 'can_send_audios', $raw),
            ValueHelper::getBoolean($result, 'can_send_documents', $raw),
            ValueHelper::getBoolean($result, 'can_send_photos', $raw),
            ValueHelper::getBoolean($result, 'can_send_videos', $raw),
            ValueHelper::getBoolean($result, 'can_send_video_notes', $raw),
            ValueHelper::getBoolean($result, 'can_send_voice_notes', $raw),
            ValueHelper::getBoolean($result, 'can_send_polls', $raw),
            ValueHelper::getBoolean($result, 'can_send_other_messages', $raw),
            ValueHelper::getBoolean($result, 'can_add_web_page_previews', $raw),
            ValueHelper::getBoolean($result, 'can_change_info', $raw),
            ValueHelper::getBoolean($result, 'can_invite_users', $raw),
            ValueHelper::getBoolean($result, 'can_pin_messages', $raw),
            ValueHelper::getBoolean($result, 'can_manage_topics', $raw),
            $untilDate,
        );
    }
}

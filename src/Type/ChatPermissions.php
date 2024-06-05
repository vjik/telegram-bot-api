<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#chatpermissions
 */
final readonly class ChatPermissions
{
    public function __construct(
        public ?bool $canSendMessages = null,
        public ?bool $canSendAudios = null,
        public ?bool $canSendDocuments = null,
        public ?bool $canSendPhotos = null,
        public ?bool $canSendVideos = null,
        public ?bool $canSendVideoNotes = null,
        public ?bool $canSendVoiceNotes = null,
        public ?bool $canSendPolls = null,
        public ?bool $canSendOtherMessages = null,
        public ?bool $canAddWebPagePreviews = null,
        public ?bool $canChangeInfo = null,
        public ?bool $canInviteUsers = null,
        public ?bool $canPinMessages = null,
        public ?bool $canManageTopics = null,
    ) {
    }

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            ValueHelper::getBooleanOrNull($result, 'can_send_messages'),
            ValueHelper::getBooleanOrNull($result, 'can_send_audios'),
            ValueHelper::getBooleanOrNull($result, 'can_send_documents'),
            ValueHelper::getBooleanOrNull($result, 'can_send_photos'),
            ValueHelper::getBooleanOrNull($result, 'can_send_videos'),
            ValueHelper::getBooleanOrNull($result, 'can_send_video_notes'),
            ValueHelper::getBooleanOrNull($result, 'can_send_voice_notes'),
            ValueHelper::getBooleanOrNull($result, 'can_send_polls'),
            ValueHelper::getBooleanOrNull($result, 'can_send_other_messages'),
            ValueHelper::getBooleanOrNull($result, 'can_add_web_page_previews'),
            ValueHelper::getBooleanOrNull($result, 'can_change_info'),
            ValueHelper::getBooleanOrNull($result, 'can_invite_users'),
            ValueHelper::getBooleanOrNull($result, 'can_pin_messages'),
            ValueHelper::getBooleanOrNull($result, 'can_manage_topics')
        );
    }
}

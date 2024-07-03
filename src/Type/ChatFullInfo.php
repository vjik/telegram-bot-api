<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use DateTimeImmutable;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#chatfullinfo
 */
final readonly class ChatFullInfo
{
    /**
     * @param string[]|null $activeUsernames
     * @param ReactionType[]|null $availableReactions
     */
    public function __construct(
        public int $id,
        public string $type,
        public int $accentColorId,
        public int $maxReactionCount,
        public ?string $title = null,
        public ?string $username = null,
        public ?string $firstName = null,
        public ?string $lastName = null,
        public ?true $isForum = null,
        public ?ChatPhoto $photo = null,
        public ?array $activeUsernames = null,
        public ?Birthdate $birthdate = null,
        public ?BusinessIntro $businessIntro = null,
        public ?BusinessLocation $businessLocation = null,
        public ?BusinessOpeningHours $businessOpeningHours = null,
        public ?Chat $personalChat = null,
        public ?array $availableReactions = null,
        public ?string $backgroundCustomEmojiId = null,
        public ?int $profileAccentColorId = null,
        public ?string $profileBackgroundCustomEmojiId = null,
        public ?string $emojiStatusCustomEmojiId = null,
        public ?DateTimeImmutable $emojiStatusExpirationDate = null,
        public ?string $bio = null,
        public ?true $hasPrivateForwards = null,
        public ?true $hasRestrictedVoiceAndVideoMessages = null,
        public ?true $joinToSendMessages = null,
        public ?true $joinByRequest = null,
        public ?string $description = null,
        public ?string $inviteLink = null,
        public ?Message $pinnedMessage = null,
        public ?ChatPermissions $permissions = null,
        public ?int $slowModeDelay = null,
        public ?int $unrestrictBoostCount = null,
        public ?int $messageAutoDeleteTime = null,
        public ?true $hasAggressiveAntiSpamEnabled = null,
        public ?true $hasHiddenMembers = null,
        public ?true $hasProtectedContent = null,
        public ?true $hasVisibleHistory = null,
        public ?string $stickerSetName = null,
        public ?true $canSetStickerSet = null,
        public ?string $customEmojiStickerSetName = null,
        public ?int $linkedChatId = null,
        public ?ChatLocation $location = null,
        public ?true $canSendPaidMedia = null,
    ) {
    }

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            ValueHelper::getInteger($result, 'id', $raw),
            ValueHelper::getString($result, 'type', $raw),
            ValueHelper::getInteger($result, 'accent_color_id', $raw),
            ValueHelper::getInteger($result, 'max_reaction_count', $raw),
            ValueHelper::getStringOrNull($result, 'title', $raw),
            ValueHelper::getStringOrNull($result, 'username', $raw),
            ValueHelper::getStringOrNull($result, 'first_name', $raw),
            ValueHelper::getStringOrNull($result, 'last_name', $raw),
            ValueHelper::getTrueOrNull($result, 'is_forum', $raw),
            array_key_exists('photo', $result)
                ? ChatPhoto::fromTelegramResult($result['photo'], $raw)
                : null,
            ValueHelper::getArrayOfStringsOrNull($result, 'active_usernames', $raw),
            array_key_exists('birthdate', $result)
                ? Birthdate::fromTelegramResult($result['birthdate'], $raw)
                : null,
            array_key_exists('business_intro', $result)
                ? BusinessIntro::fromTelegramResult($result['business_intro'], $raw)
                : null,
            array_key_exists('business_location', $result)
                ? BusinessLocation::fromTelegramResult($result['business_location'], $raw)
                : null,
            array_key_exists('business_opening_hours', $result)
                ? BusinessOpeningHours::fromTelegramResult($result['business_opening_hours'], $raw)
                : null,
            array_key_exists('personal_chat', $result)
                ? Chat::fromTelegramResult($result['personal_chat'], $raw)
                : null,
            ValueHelper::getArrayOfReactionTypesOrNull($result, 'available_reactions', $raw),
            ValueHelper::getStringOrNull($result, 'background_custom_emoji_id', $raw),
            ValueHelper::getIntegerOrNull($result, 'profile_accent_color_id', $raw),
            ValueHelper::getStringOrNull($result, 'profile_background_custom_emoji_id', $raw),
            ValueHelper::getStringOrNull($result, 'emoji_status_custom_emoji_id', $raw),
            ValueHelper::getDateTimeImmutableOrNull($result, 'emoji_status_expiration_date', $raw),
            ValueHelper::getStringOrNull($result, 'bio', $raw),
            ValueHelper::getTrueOrNull($result, 'has_private_forwards', $raw),
            ValueHelper::getTrueOrNull($result, 'has_restricted_voice_and_video_messages', $raw),
            ValueHelper::getTrueOrNull($result, 'join_to_send_messages', $raw),
            ValueHelper::getTrueOrNull($result, 'join_by_request', $raw),
            ValueHelper::getStringOrNull($result, 'description', $raw),
            ValueHelper::getStringOrNull($result, 'invite_link', $raw),
            array_key_exists('pinned_message', $result)
                ? Message::fromTelegramResult($result['pinned_message'], $raw)
                : null,
            array_key_exists('permissions', $result)
                ? ChatPermissions::fromTelegramResult($result['permissions'], $raw)
                : null,
            ValueHelper::getIntegerOrNull($result, 'slow_mode_delay', $raw),
            ValueHelper::getIntegerOrNull($result, 'unrestrict_boost_count', $raw),
            ValueHelper::getIntegerOrNull($result, 'message_auto_delete_time', $raw),
            ValueHelper::getTrueOrNull($result, 'has_aggressive_anti_spam_enabled', $raw),
            ValueHelper::getTrueOrNull($result, 'has_hidden_members', $raw),
            ValueHelper::getTrueOrNull($result, 'has_protected_content', $raw),
            ValueHelper::getTrueOrNull($result, 'has_visible_history', $raw),
            ValueHelper::getStringOrNull($result, 'sticker_set_name', $raw),
            ValueHelper::getTrueOrNull($result, 'can_set_sticker_set', $raw),
            ValueHelper::getStringOrNull($result, 'custom_emoji_sticker_set_name', $raw),
            ValueHelper::getIntegerOrNull($result, 'linked_chat_id', $raw),
            array_key_exists('location', $result)
                ? ChatLocation::fromTelegramResult($result['location'], $raw)
                : null,
            ValueHelper::getTrueOrNull($result, 'can_send_paid_media', $raw),
        );
    }
}

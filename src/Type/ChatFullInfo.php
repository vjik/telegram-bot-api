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
        public ?string $title,
        public ?string $username,
        public ?string $firstName,
        public ?string $lastName,
        public ?true $isForum,
        public int $accentColorId,
        public int $maxReactionCount,
        public ?ChatPhoto $photo,
        public ?array $activeUsernames,
        public ?Birthdate $birthdate,
        public ?BusinessIntro $businessIntro,
        public ?BusinessLocation $businessLocation,
        public ?BusinessOpeningHours $businessOpeningHours,
        public ?Chat $personalChat,
        public ?array $availableReactions,
        public ?string $backgroundCustomEmojiId,
        public ?int $profileAccentColorId,
        public ?string $profileBackgroundCustomEmojiId,
        public ?string $emojiStatusCustomEmojiId,
        public ?DateTimeImmutable $emojiStatusExpirationDate,
        public ?string $bio,
        public ?true $hasPrivateForwards,
        public ?true $hasRestrictedVoiceAndVideoMessages,
        public ?true $joinToSendMessages,
        public ?true $joinByRequest,
        public ?string $description,
        public ?string $inviteLink,
        public ?Message $pinnedMessage,
        public ?ChatPermissions $permissions,
        public ?int $slowModeDelay,
        public ?int $unrestrictBoostCount,
        public ?int $messageAutoDeleteTime,
        public ?true $hasAggressiveAntiSpamEnabled,
        public ?true $hasHiddenMembers,
        public ?true $hasProtectedContent,
        public ?true $hasVisibleHistory,
        public ?string $stickerSetName,
        public ?true $canSetStickerSet,
        public ?string $customEmojiStickerSetName,
        public ?int $linkedChatId,
        public ?ChatLocation $location,
    ) {
    }

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            ValueHelper::getInteger($result, 'id'),
            ValueHelper::getString($result, 'type'),
            ValueHelper::getStringOrNull($result, 'title'),
            ValueHelper::getStringOrNull($result, 'username'),
            ValueHelper::getStringOrNull($result, 'first_name'),
            ValueHelper::getStringOrNull($result, 'last_name'),
            ValueHelper::getTrueOrNull($result, 'is_forum'),
            ValueHelper::getInteger($result, 'accent_color_id'),
            ValueHelper::getInteger($result, 'max_reaction_count'),
            array_key_exists('photo', $result)
                ? ChatPhoto::fromTelegramResult($result['photo'])
                : null,
            ValueHelper::getArrayOfStringsOrNull($result, 'active_usernames'),
            array_key_exists('birthdate', $result)
                ? Birthdate::fromTelegramResult($result['birthdate'])
                : null,
            array_key_exists('business_intro', $result)
                ? BusinessIntro::fromTelegramResult($result['business_intro'])
                : null,
            array_key_exists('business_location', $result)
                ? BusinessLocation::fromTelegramResult($result['business_location'])
                : null,
            array_key_exists('business_opening_hours', $result)
                ? BusinessOpeningHours::fromTelegramResult($result['business_opening_hours'])
                : null,
            array_key_exists('personal_chat', $result)
                ? Chat::fromTelegramResult($result['personal_chat'])
                : null,
            ValueHelper::getArrayOfReactionTypesOrNull($result, 'available_reactions'),
            ValueHelper::getStringOrNull($result, 'background_custom_emoji_id'),
            ValueHelper::getIntegerOrNull($result, 'profile_accent_color_id'),
            ValueHelper::getStringOrNull($result, 'profile_background_custom_emoji_id'),
            ValueHelper::getStringOrNull($result, 'emoji_status_custom_emoji_id'),
            ValueHelper::getDateTimeImmutableOrNull($result, 'emoji_status_expiration_date'),
            ValueHelper::getStringOrNull($result, 'bio'),
            ValueHelper::getTrueOrNull($result, 'has_private_forwards'),
            ValueHelper::getTrueOrNull($result, 'has_restricted_voice_and_video_messages'),
            ValueHelper::getTrueOrNull($result, 'join_to_send_messages'),
            ValueHelper::getTrueOrNull($result, 'join_by_request'),
            ValueHelper::getStringOrNull($result, 'description'),
            ValueHelper::getStringOrNull($result, 'invite_link'),
            array_key_exists('pinned_message', $result)
                ? Message::fromTelegramResult($result['pinned_message'])
                : null,
            array_key_exists('permissions', $result)
                ? ChatPermissions::fromTelegramResult($result['permissions'])
                : null,
            ValueHelper::getIntegerOrNull($result, 'slow_mode_delay'),
            ValueHelper::getIntegerOrNull($result, 'unrestrict_boost_count'),
            ValueHelper::getIntegerOrNull($result, 'message_auto_delete_time'),
            ValueHelper::getTrueOrNull($result, 'has_aggressive_anti_spam_enabled'),
            ValueHelper::getTrueOrNull($result, 'has_hidden_members'),
            ValueHelper::getTrueOrNull($result, 'has_protected_content'),
            ValueHelper::getTrueOrNull($result, 'has_visible_history'),
            ValueHelper::getStringOrNull($result, 'sticker_set_name'),
            ValueHelper::getTrueOrNull($result, 'can_set_sticker_set'),
            ValueHelper::getStringOrNull($result, 'custom_emoji_sticker_set_name'),
            ValueHelper::getIntegerOrNull($result, 'linked_chat_id'),
            array_key_exists('location', $result)
                ? ChatLocation::fromTelegramResult($result['location'])
                : null,
        );
    }
}

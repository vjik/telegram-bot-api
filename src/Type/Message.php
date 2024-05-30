<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use DateTimeImmutable;
use Vjik\TelegramBot\Api\ParseResult\NotFoundKeyInResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;
use Vjik\TelegramBot\Api\Type\Game\Game;
use Vjik\TelegramBot\Api\Type\Passport\PassportData;
use Vjik\TelegramBot\Api\Type\Payments\Invoice;
use Vjik\TelegramBot\Api\Type\Payments\SuccessfulPayment;
use Vjik\TelegramBot\Api\Type\Sticker\Sticker;

/**
 * @see https://core.telegram.org/bots/api#message
 */
final readonly class Message
{
    /**
     * @param MessageEntity[]|null $entities
     * @param PhotoSize[]|null $photo
     * @param MessageEntity[]|null $captionEntities
     * @param User[]|null $newChatMembers
     * @param PhotoSize[]|null $newChatPhoto
     */
    public function __construct(
        public int $messageId,
        public ?int $messageThreadId,
        public ?User $from,
        public ?Chat $senderChat,
        public ?int $senderBoostCount,
        public ?User $senderBusinessBot,
        public DateTimeImmutable $date,
        public ?string $businessConnectionId,
        public Chat $chat,
        public ?MessageOrigin $forwardOrigin,
        public ?true $isTopicMessage,
        public ?true $isAutomaticForward,
        public ?Message $replyToMessage,
        public ?ExternalReplyInfo $externalReply,
        public ?TextQuote $quote,
        public ?Story $replyToStory,
        public ?User $viaBot,
        public ?DateTimeImmutable $editDate,
        public ?true $hasProtectedContent,
        public ?true $isFromOffline,
        public ?string $mediaGroupId,
        public ?string $authorSignature,
        public ?string $text,
        public ?array $entities,
        public ?LinkPreviewOptions $linkPreviewOptions,
        public ?string $effectId,
        public ?Animation $animation,
        public ?Audio $audio,
        public ?Document $document,
        public ?array $photo,
        public ?Sticker $sticker,
        public ?Story $story,
        public ?Video $video,
        public ?VideoNote $videoNote,
        public ?Voice $voice,
        public ?string $caption,
        public ?array $captionEntities,
        public ?true $showCaptionAboveMedia,
        public ?true $hasMediaSpoiler,
        public ?Contact $contact,
        public ?Dice $dice,
        public ?Game $game,
        public ?Poll $poll,
        public ?Venue $venue,
        public ?Location $location,
        public ?array $newChatMembers,
        public ?User $leftChatMember,
        public ?string $newChatTitle,
        public ?array $newChatPhoto,
        public ?true $deleteChatPhoto,
        public ?true $groupChatCreated,
        public ?true $supergroupChatCreated,
        public ?true $channelChatCreated,
        public ?MessageAutoDeleteTimerChanged $messageAutoDeleteTimerChanged,
        public ?int $migrateToChatId,
        public ?int $migrateFromChatId,
        public Message|InaccessibleMessage|null $pinnedMessage,
        public ?Invoice $invoice,
        public ?SuccessfulPayment $successfulPayment,
        public ?UsersShared $usersShared,
        public ?ChatShared $chatShared,
        public ?string $connectedWebsite,
        public ?WriteAccessAllowed $writeAccessAllowed,
        public ?PassportData $passportData,
        public ?ProximityAlertTriggered $proximityAlertTriggered,
        public ?ChatBoostAdded $boostAdded,
        public ?ChatBackground $chatBackgroundSet,
        public ?ForumTopicCreated $forumTopicCreated,
        public ?ForumTopicEdited $forumTopicEdited,
        public ?ForumTopicClosed $forumTopicClosed,
        public ?ForumTopicReopened $forumTopicReopened,
        public ?GeneralForumTopicHidden $generalForumTopicHidden,
        public ?GeneralForumTopicUnhidden $generalForumTopicUnhidden,
        public ?GiveawayCreated $giveawayCreated,
        public ?Giveaway $giveaway,
        public ?GiveawayWinners $giveawayWinners,
        public ?GiveawayCompleted $giveawayCompleted,
        public ?VideoChatScheduled $videoChatScheduled,
        public ?VideoChatStarted $videoChatStarted,
        public ?VideoChatEnded $videoChatEnded,
        public ?VideoChatParticipantsInvited $videoChatParticipantsInvited,
        public ?WebAppData $webAppData,
        public ?InlineKeyboardMarkup $replyMarkup,
    ) {
    }

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            ValueHelper::getInteger($result, 'message_id'),
            ValueHelper::getIntegerOrNull($result, 'message_thread_id'),
            array_key_exists('from', $result) ? User::fromTelegramResult($result['from']) : null,
            array_key_exists('sender_chat', $result) ? Chat::fromTelegramResult($result['sender_chat']) : null,
            ValueHelper::getIntegerOrNull($result, 'sender_boost_count'),
            array_key_exists('sender_business_bot', $result)
                ? User::fromTelegramResult($result['sender_business_bot'])
                : null,
            ValueHelper::getDateTimeImmutable($result, 'date'),
            ValueHelper::getStringOrNull($result, 'business_connection_id'),
            array_key_exists('chat', $result)
                ? Chat::fromTelegramResult($result['chat'])
                : throw new NotFoundKeyInResultException('chat'),
            array_key_exists('forward_origin', $result)
                ? MessageOriginFactory::fromTelegramResult($result['forward_origin'])
                : null,
            ValueHelper::getTrueOrNull($result, 'is_topic_message'),
            ValueHelper::getTrueOrNull($result, 'is_automatic_forward'),
            array_key_exists('reply_to_message', $result)
                ? Message::fromTelegramResult($result['reply_to_message'])
                : null,
            array_key_exists('external_reply', $result)
                ? ExternalReplyInfo::fromTelegramResult($result['external_reply'])
                : null,
            array_key_exists('quote', $result)
                ? TextQuote::fromTelegramResult($result['quote'])
                : null,
            array_key_exists('reply_to_story', $result)
                ? Story::fromTelegramResult($result['reply_to_story'])
                : null,
            array_key_exists('via_bot', $result)
                ? User::fromTelegramResult($result['via_bot'])
                : null,
            ValueHelper::getDateTimeImmutableOrNull($result, 'edit_date'),
            ValueHelper::getTrueOrNull($result, 'has_protected_content'),
            ValueHelper::getTrueOrNull($result, 'is_from_offline'),
            ValueHelper::getStringOrNull($result, 'media_group_id'),
            ValueHelper::getStringOrNull($result, 'author_signature'),
            ValueHelper::getStringOrNull($result, 'text'),
            ValueHelper::getArrayOfMessageEntitiesOrNull($result, 'entities'),
            array_key_exists('link_preview_options', $result)
                ? LinkPreviewOptions::fromTelegramResult($result['link_preview_options'])
                : null,
            ValueHelper::getStringOrNull($result, 'effect_id'),
            array_key_exists('animation', $result)
                ? Animation::fromTelegramResult($result['animation'])
                : null,
            array_key_exists('audio', $result)
                ? Audio::fromTelegramResult($result['audio'])
                : null,
            array_key_exists('document', $result)
                ? Document::fromTelegramResult($result['document'])
                : null,
            ValueHelper::getArrayOfPhotoSizesOrNull($result, 'photo'),
            array_key_exists('sticker', $result)
                ? Sticker::fromTelegramResult($result['sticker'])
                : null,
            array_key_exists('story', $result)
                ? Story::fromTelegramResult($result['story'])
                : null,
            array_key_exists('video', $result)
                ? Video::fromTelegramResult($result['video'])
                : null,
            array_key_exists('video_note', $result)
                ? VideoNote::fromTelegramResult($result['video_note'])
                : null,
            array_key_exists('voice', $result)
                ? Voice::fromTelegramResult($result['voice'])
                : null,
            ValueHelper::getStringOrNull($result, 'caption'),
            ValueHelper::getArrayOfMessageEntitiesOrNull($result, 'caption_entities'),
            ValueHelper::getTrueOrNull($result, 'show_caption_above_media'),
            ValueHelper::getTrueOrNull($result, 'has_media_spoiler'),
            array_key_exists('contact', $result)
                ? Contact::fromTelegramResult($result['contact'])
                : null,
            array_key_exists('dice', $result)
                ? Dice::fromTelegramResult($result['dice'])
                : null,
            array_key_exists('game', $result)
                ? Game::fromTelegramResult($result['game'])
                : null,
            array_key_exists('poll', $result)
                ? Poll::fromTelegramResult($result['poll'])
                : null,
            array_key_exists('venue', $result)
                ? Venue::fromTelegramResult($result['venue'])
                : null,
            array_key_exists('location', $result)
                ? Location::fromTelegramResult($result['location'])
                : null,
            ValueHelper::getArrayOfUsersOrNull($result, 'new_chat_members'),
            array_key_exists('left_chat_member', $result)
                ? User::fromTelegramResult($result['left_chat_member'])
                : null,
            ValueHelper::getStringOrNull($result, 'new_chat_title'),
            ValueHelper::getArrayOfPhotoSizesOrNull($result, 'new_chat_photo'),
            ValueHelper::getTrueOrNull($result, 'delete_chat_photo'),
            ValueHelper::getTrueOrNull($result, 'group_chat_created'),
            ValueHelper::getTrueOrNull($result, 'supergroup_chat_created'),
            ValueHelper::getTrueOrNull($result, 'channel_chat_created'),
            array_key_exists('message_auto_delete_timer_changed', $result)
                ? MessageAutoDeleteTimerChanged::fromTelegramResult($result['message_auto_delete_timer_changed'])
                : null,
            ValueHelper::getIntegerOrNull($result, 'migrate_to_chat_id'),
            ValueHelper::getIntegerOrNull($result, 'migrate_from_chat_id'),
            array_key_exists('pinned_message', $result)
                ? MaybeInaccessibleMessageFactory::fromTelegramResult($result['pinned_message'])
                : null,
            array_key_exists('invoice', $result)
                ? Invoice::fromTelegramResult($result['invoice'])
                : null,
            array_key_exists('successful_payment', $result)
                ? SuccessfulPayment::fromTelegramResult($result['successful_payment'])
                : null,
            array_key_exists('users_shared', $result)
                ? UsersShared::fromTelegramResult($result['users_shared'])
                : null,
            array_key_exists('chat_shared', $result)
                ? ChatShared::fromTelegramResult($result['chat_shared'])
                : null,
            ValueHelper::getStringOrNull($result, 'connected_website'),
            array_key_exists('write_access_allowed', $result)
                ? WriteAccessAllowed::fromTelegramResult($result['write_access_allowed'])
                : null,
            array_key_exists('passport_data', $result)
                ? PassportData::fromTelegramResult($result['passport_data'])
                : null,
            array_key_exists('proximity_alert_triggered', $result)
                ? ProximityAlertTriggered::fromTelegramResult($result['proximity_alert_triggered'])
                : null,
            array_key_exists('boost_added', $result)
                ? ChatBoostAdded::fromTelegramResult($result['boost_added'])
                : null,
            array_key_exists('chat_background_set', $result)
                ? ChatBackground::fromTelegramResult($result['chat_background_set'])
                : null,
            array_key_exists('forum_topic_created', $result)
                ? ForumTopicCreated::fromTelegramResult($result['forum_topic_created'])
                : null,
            array_key_exists('forum_topic_edited', $result)
                ? ForumTopicEdited::fromTelegramResult($result['forum_topic_edited'])
                : null,
            array_key_exists('forum_topic_closed', $result)
                ? ForumTopicClosed::fromTelegramResult($result['forum_topic_closed'])
                : null,
            array_key_exists('forum_topic_reopened', $result)
                ? ForumTopicReopened::fromTelegramResult($result['forum_topic_reopened'])
                : null,
            array_key_exists('general_forum_topic_hidden', $result)
                ? GeneralForumTopicHidden::fromTelegramResult($result['general_forum_topic_hidden'])
                : null,
            array_key_exists('general_forum_topic_unhidden', $result)
                ? GeneralForumTopicUnhidden::fromTelegramResult($result['general_forum_topic_unhidden'])
                : null,
            array_key_exists('giveaway_created', $result)
                ? GiveawayCreated::fromTelegramResult($result['giveaway_created'])
                : null,
            array_key_exists('giveaway', $result)
                ? Giveaway::fromTelegramResult($result['giveaway'])
                : null,
            array_key_exists('giveaway_winners', $result)
                ? GiveawayWinners::fromTelegramResult($result['giveaway_winners'])
                : null,
            array_key_exists('giveaway_completed', $result)
                ? GiveawayCompleted::fromTelegramResult($result['giveaway_completed'])
                : null,
            array_key_exists('video_chat_scheduled', $result)
                ? VideoChatScheduled::fromTelegramResult($result['video_chat_scheduled'])
                : null,
            array_key_exists('video_chat_started', $result)
                ? VideoChatStarted::fromTelegramResult($result['video_chat_started'])
                : null,
            array_key_exists('video_chat_ended', $result)
                ? VideoChatEnded::fromTelegramResult($result['video_chat_ended'])
                : null,
            array_key_exists('video_chat_participants_invited', $result)
                ? VideoChatParticipantsInvited::fromTelegramResult($result['video_chat_participants_invited'])
                : null,
            array_key_exists('web_app_data', $result)
                ? WebAppData::fromTelegramResult($result['web_app_data'])
                : null,
            array_key_exists('reply_markup', $result)
                ? InlineKeyboardMarkup::fromTelegramResult($result['reply_markup'])
                : null,
        );
    }
}

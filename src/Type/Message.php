<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use DateTimeImmutable;
use Vjik\TelegramBot\Api\ParseResult\NotFoundKeyInResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;
use Vjik\TelegramBot\Api\Type\Game\Game;
use Vjik\TelegramBot\Api\Type\Passport\PassportData;
use Vjik\TelegramBot\Api\Type\Payment\Invoice;
use Vjik\TelegramBot\Api\Type\Payment\SuccessfulPayment;
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
        public DateTimeImmutable $date,
        public Chat $chat,
        public ?int $messageThreadId = null,
        public ?User $from = null,
        public ?Chat $senderChat = null,
        public ?int $senderBoostCount = null,
        public ?User $senderBusinessBot = null,
        public ?string $businessConnectionId = null,
        public ?MessageOrigin $forwardOrigin = null,
        public ?true $isTopicMessage = null,
        public ?true $isAutomaticForward = null,
        public ?Message $replyToMessage = null,
        public ?ExternalReplyInfo $externalReply = null,
        public ?TextQuote $quote = null,
        public ?Story $replyToStory = null,
        public ?User $viaBot = null,
        public ?DateTimeImmutable $editDate = null,
        public ?true $hasProtectedContent = null,
        public ?true $isFromOffline = null,
        public ?string $mediaGroupId = null,
        public ?string $authorSignature = null,
        public ?string $text = null,
        public ?array $entities = null,
        public ?LinkPreviewOptions $linkPreviewOptions = null,
        public ?string $effectId = null,
        public ?Animation $animation = null,
        public ?Audio $audio = null,
        public ?Document $document = null,
        public ?array $photo = null,
        public ?Sticker $sticker = null,
        public ?Story $story = null,
        public ?Video $video = null,
        public ?VideoNote $videoNote = null,
        public ?Voice $voice = null,
        public ?string $caption = null,
        public ?array $captionEntities = null,
        public ?true $showCaptionAboveMedia = null,
        public ?true $hasMediaSpoiler = null,
        public ?Contact $contact = null,
        public ?Dice $dice = null,
        public ?Game $game = null,
        public ?Poll $poll = null,
        public ?Venue $venue = null,
        public ?Location $location = null,
        public ?array $newChatMembers = null,
        public ?User $leftChatMember = null,
        public ?string $newChatTitle = null,
        public ?array $newChatPhoto = null,
        public ?true $deleteChatPhoto = null,
        public ?true $groupChatCreated = null,
        public ?true $supergroupChatCreated = null,
        public ?true $channelChatCreated = null,
        public ?MessageAutoDeleteTimerChanged $messageAutoDeleteTimerChanged = null,
        public ?int $migrateToChatId = null,
        public ?int $migrateFromChatId = null,
        public Message|InaccessibleMessage|null $pinnedMessage = null,
        public ?Invoice $invoice = null,
        public ?SuccessfulPayment $successfulPayment = null,
        public ?UsersShared $usersShared = null,
        public ?ChatShared $chatShared = null,
        public ?string $connectedWebsite = null,
        public ?WriteAccessAllowed $writeAccessAllowed = null,
        public ?PassportData $passportData = null,
        public ?ProximityAlertTriggered $proximityAlertTriggered = null,
        public ?ChatBoostAdded $boostAdded = null,
        public ?ChatBackground $chatBackgroundSet = null,
        public ?ForumTopicCreated $forumTopicCreated = null,
        public ?ForumTopicEdited $forumTopicEdited = null,
        public ?ForumTopicClosed $forumTopicClosed = null,
        public ?ForumTopicReopened $forumTopicReopened = null,
        public ?GeneralForumTopicHidden $generalForumTopicHidden = null,
        public ?GeneralForumTopicUnhidden $generalForumTopicUnhidden = null,
        public ?GiveawayCreated $giveawayCreated = null,
        public ?Giveaway $giveaway = null,
        public ?GiveawayWinners $giveawayWinners = null,
        public ?GiveawayCompleted $giveawayCompleted = null,
        public ?VideoChatScheduled $videoChatScheduled = null,
        public ?VideoChatStarted $videoChatStarted = null,
        public ?VideoChatEnded $videoChatEnded = null,
        public ?VideoChatParticipantsInvited $videoChatParticipantsInvited = null,
        public ?WebAppData $webAppData = null,
        public ?InlineKeyboardMarkup $replyMarkup = null,
        public ?PaidMediaInfo $paidMedia = null,
    ) {
    }

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            ValueHelper::getInteger($result, 'message_id', $raw),
            ValueHelper::getDateTimeImmutable($result, 'date', $raw),
            array_key_exists('chat', $result)
                ? Chat::fromTelegramResult($result['chat'], $raw)
                : throw new NotFoundKeyInResultException('chat', $raw),
            ValueHelper::getIntegerOrNull($result, 'message_thread_id', $raw),
            array_key_exists('from', $result)
                ? User::fromTelegramResult($result['from'], $raw)
                : null,
            array_key_exists('sender_chat', $result)
                ? Chat::fromTelegramResult($result['sender_chat'], $raw)
                : null,
            ValueHelper::getIntegerOrNull($result, 'sender_boost_count', $raw),
            array_key_exists('sender_business_bot', $result)
                ? User::fromTelegramResult($result['sender_business_bot'], $raw)
                : null,
            ValueHelper::getStringOrNull($result, 'business_connection_id', $raw),
            array_key_exists('forward_origin', $result)
                ? MessageOriginFactory::fromTelegramResult($result['forward_origin'], $raw)
                : null,
            ValueHelper::getTrueOrNull($result, 'is_topic_message', $raw),
            ValueHelper::getTrueOrNull($result, 'is_automatic_forward', $raw),
            array_key_exists('reply_to_message', $result)
                ? Message::fromTelegramResult($result['reply_to_message'], $raw)
                : null,
            array_key_exists('external_reply', $result)
                ? ExternalReplyInfo::fromTelegramResult($result['external_reply'], $raw)
                : null,
            array_key_exists('quote', $result)
                ? TextQuote::fromTelegramResult($result['quote'], $raw)
                : null,
            array_key_exists('reply_to_story', $result)
                ? Story::fromTelegramResult($result['reply_to_story'], $raw)
                : null,
            array_key_exists('via_bot', $result)
                ? User::fromTelegramResult($result['via_bot'], $raw)
                : null,
            ValueHelper::getDateTimeImmutableOrNull($result, 'edit_date', $raw),
            ValueHelper::getTrueOrNull($result, 'has_protected_content', $raw),
            ValueHelper::getTrueOrNull($result, 'is_from_offline', $raw),
            ValueHelper::getStringOrNull($result, 'media_group_id', $raw),
            ValueHelper::getStringOrNull($result, 'author_signature', $raw),
            ValueHelper::getStringOrNull($result, 'text', $raw),
            ValueHelper::getArrayOfMessageEntitiesOrNull($result, 'entities', $raw),
            array_key_exists('link_preview_options', $result)
                ? LinkPreviewOptions::fromTelegramResult($result['link_preview_options'], $raw)
                : null,
            ValueHelper::getStringOrNull($result, 'effect_id', $raw),
            array_key_exists('animation', $result)
                ? Animation::fromTelegramResult($result['animation'], $raw)
                : null,
            array_key_exists('audio', $result)
                ? Audio::fromTelegramResult($result['audio'], $raw)
                : null,
            array_key_exists('document', $result)
                ? Document::fromTelegramResult($result['document'], $raw)
                : null,
            ValueHelper::getArrayOfPhotoSizesOrNull($result, 'photo', $raw),
            array_key_exists('sticker', $result)
                ? Sticker::fromTelegramResult($result['sticker'], $raw)
                : null,
            array_key_exists('story', $result)
                ? Story::fromTelegramResult($result['story'], $raw)
                : null,
            array_key_exists('video', $result)
                ? Video::fromTelegramResult($result['video'], $raw)
                : null,
            array_key_exists('video_note', $result)
                ? VideoNote::fromTelegramResult($result['video_note'], $raw)
                : null,
            array_key_exists('voice', $result)
                ? Voice::fromTelegramResult($result['voice'], $raw)
                : null,
            ValueHelper::getStringOrNull($result, 'caption', $raw),
            ValueHelper::getArrayOfMessageEntitiesOrNull($result, 'caption_entities', $raw),
            ValueHelper::getTrueOrNull($result, 'show_caption_above_media', $raw),
            ValueHelper::getTrueOrNull($result, 'has_media_spoiler', $raw),
            array_key_exists('contact', $result)
                ? Contact::fromTelegramResult($result['contact'], $raw)
                : null,
            array_key_exists('dice', $result)
                ? Dice::fromTelegramResult($result['dice'], $raw)
                : null,
            array_key_exists('game', $result)
                ? Game::fromTelegramResult($result['game'], $raw)
                : null,
            array_key_exists('poll', $result)
                ? Poll::fromTelegramResult($result['poll'], $raw)
                : null,
            array_key_exists('venue', $result)
                ? Venue::fromTelegramResult($result['venue'], $raw)
                : null,
            array_key_exists('location', $result)
                ? Location::fromTelegramResult($result['location'], $raw)
                : null,
            ValueHelper::getArrayOfUsersOrNull($result, 'new_chat_members', $raw),
            array_key_exists('left_chat_member', $result)
                ? User::fromTelegramResult($result['left_chat_member'], $raw)
                : null,
            ValueHelper::getStringOrNull($result, 'new_chat_title', $raw),
            ValueHelper::getArrayOfPhotoSizesOrNull($result, 'new_chat_photo', $raw),
            ValueHelper::getTrueOrNull($result, 'delete_chat_photo', $raw),
            ValueHelper::getTrueOrNull($result, 'group_chat_created', $raw),
            ValueHelper::getTrueOrNull($result, 'supergroup_chat_created', $raw),
            ValueHelper::getTrueOrNull($result, 'channel_chat_created', $raw),
            array_key_exists('message_auto_delete_timer_changed', $result)
                ? MessageAutoDeleteTimerChanged::fromTelegramResult($result['message_auto_delete_timer_changed'], $raw)
                : null,
            ValueHelper::getIntegerOrNull($result, 'migrate_to_chat_id', $raw),
            ValueHelper::getIntegerOrNull($result, 'migrate_from_chat_id', $raw),
            array_key_exists('pinned_message', $result)
                ? MaybeInaccessibleMessageFactory::fromTelegramResult($result['pinned_message'], $raw)
                : null,
            array_key_exists('invoice', $result)
                ? Invoice::fromTelegramResult($result['invoice'], $raw)
                : null,
            array_key_exists('successful_payment', $result)
                ? SuccessfulPayment::fromTelegramResult($result['successful_payment'], $raw)
                : null,
            array_key_exists('users_shared', $result)
                ? UsersShared::fromTelegramResult($result['users_shared'], $raw)
                : null,
            array_key_exists('chat_shared', $result)
                ? ChatShared::fromTelegramResult($result['chat_shared'], $raw)
                : null,
            ValueHelper::getStringOrNull($result, 'connected_website', $raw),
            array_key_exists('write_access_allowed', $result)
                ? WriteAccessAllowed::fromTelegramResult($result['write_access_allowed'], $raw)
                : null,
            array_key_exists('passport_data', $result)
                ? PassportData::fromTelegramResult($result['passport_data'], $raw)
                : null,
            array_key_exists('proximity_alert_triggered', $result)
                ? ProximityAlertTriggered::fromTelegramResult($result['proximity_alert_triggered'], $raw)
                : null,
            array_key_exists('boost_added', $result)
                ? ChatBoostAdded::fromTelegramResult($result['boost_added'], $raw)
                : null,
            array_key_exists('chat_background_set', $result)
                ? ChatBackground::fromTelegramResult($result['chat_background_set'], $raw)
                : null,
            array_key_exists('forum_topic_created', $result)
                ? ForumTopicCreated::fromTelegramResult($result['forum_topic_created'], $raw)
                : null,
            array_key_exists('forum_topic_edited', $result)
                ? ForumTopicEdited::fromTelegramResult($result['forum_topic_edited'], $raw)
                : null,
            array_key_exists('forum_topic_closed', $result)
                ? ForumTopicClosed::fromTelegramResult($result['forum_topic_closed'], $raw)
                : null,
            array_key_exists('forum_topic_reopened', $result)
                ? ForumTopicReopened::fromTelegramResult($result['forum_topic_reopened'], $raw)
                : null,
            array_key_exists('general_forum_topic_hidden', $result)
                ? GeneralForumTopicHidden::fromTelegramResult($result['general_forum_topic_hidden'], $raw)
                : null,
            array_key_exists('general_forum_topic_unhidden', $result)
                ? GeneralForumTopicUnhidden::fromTelegramResult($result['general_forum_topic_unhidden'], $raw)
                : null,
            array_key_exists('giveaway_created', $result)
                ? GiveawayCreated::fromTelegramResult($result['giveaway_created'], $raw)
                : null,
            array_key_exists('giveaway', $result)
                ? Giveaway::fromTelegramResult($result['giveaway'], $raw)
                : null,
            array_key_exists('giveaway_winners', $result)
                ? GiveawayWinners::fromTelegramResult($result['giveaway_winners'], $raw)
                : null,
            array_key_exists('giveaway_completed', $result)
                ? GiveawayCompleted::fromTelegramResult($result['giveaway_completed'], $raw)
                : null,
            array_key_exists('video_chat_scheduled', $result)
                ? VideoChatScheduled::fromTelegramResult($result['video_chat_scheduled'], $raw)
                : null,
            array_key_exists('video_chat_started', $result)
                ? VideoChatStarted::fromTelegramResult($result['video_chat_started'], $raw)
                : null,
            array_key_exists('video_chat_ended', $result)
                ? VideoChatEnded::fromTelegramResult($result['video_chat_ended'], $raw)
                : null,
            array_key_exists('video_chat_participants_invited', $result)
                ? VideoChatParticipantsInvited::fromTelegramResult($result['video_chat_participants_invited'], $raw)
                : null,
            array_key_exists('web_app_data', $result)
                ? WebAppData::fromTelegramResult($result['web_app_data'], $raw)
                : null,
            array_key_exists('reply_markup', $result)
                ? InlineKeyboardMarkup::fromTelegramResult($result['reply_markup'], $raw)
                : null,
            array_key_exists('paid_media', $result)
                ? PaidMediaInfo::fromTelegramResult($result['paid_media'], $raw)
                : null,
        );
    }
}

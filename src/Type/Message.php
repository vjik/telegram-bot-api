<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use DateTimeImmutable;
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
}

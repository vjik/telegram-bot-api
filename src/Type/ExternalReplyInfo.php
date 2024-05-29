<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\Type\Game\Game;
use Vjik\TelegramBot\Api\Type\Payments\Invoice;
use Vjik\TelegramBot\Api\Type\Sticker\Sticker;

/**
 * @see https://core.telegram.org/bots/api#externalreplyinfo
 */
final readonly class ExternalReplyInfo
{
    /**
     * @param PhotoSize[]|null $photo
     */
    public function __construct(
        public MessageOrigin $origin,
        public ?Chat $chat,
        public ?int $messageId,
        public ?LinkPreviewOptions $linkPreviewOptions,
        public ?Animation $animation,
        public ?Audio $audio,
        public ?Document $document,
        public ?array $photo,
        public ?Sticker $sticker,
        public ?Story $story,
        public ?Video $video,
        public ?VideoNote $videoNote,
        public ?Voice $voice,
        public ?true $hasMediaSpoiler,
        public ?Contact $contact,
        public ?Dice $dice,
        public ?Game $game,
        public ?Giveaway $giveaway,
        public ?GiveawayWinners $giveawayWinners,
        public ?Invoice $invoice,
        public ?Location $location,
        public ?Poll $poll,
        public ?Venue $venue,
    ) {
    }
}

<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ArrayOfObjectsValue;
use Vjik\TelegramBot\Api\Type\Game\Game;
use Vjik\TelegramBot\Api\Type\Payment\Invoice;
use Vjik\TelegramBot\Api\Type\Sticker\Sticker;

/**
 * @see https://core.telegram.org/bots/api#externalreplyinfo
 *
 * @api
 */
final readonly class ExternalReplyInfo
{
    /**
     * @param PhotoSize[]|null $photo
     */
    public function __construct(
        public MessageOrigin $origin,
        public ?Chat $chat = null,
        public ?int $messageId = null,
        public ?LinkPreviewOptions $linkPreviewOptions = null,
        public ?Animation $animation = null,
        public ?Audio $audio = null,
        public ?Document $document = null,
        #[ArrayOfObjectsValue(PhotoSize::class)]
        public ?array $photo = null,
        public ?Sticker $sticker = null,
        public ?Story $story = null,
        public ?Video $video = null,
        public ?VideoNote $videoNote = null,
        public ?Voice $voice = null,
        public ?true $hasMediaSpoiler = null,
        public ?Contact $contact = null,
        public ?Dice $dice = null,
        public ?Game $game = null,
        public ?Giveaway $giveaway = null,
        public ?GiveawayWinners $giveawayWinners = null,
        public ?Invoice $invoice = null,
        public ?Location $location = null,
        public ?Poll $poll = null,
        public ?Venue $venue = null,
        public ?PaidMediaInfo $paidMedia = null,
        public ?Checklist $checklist = null,
    ) {}
}

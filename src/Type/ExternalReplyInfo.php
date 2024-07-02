<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\NotFoundKeyInResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;
use Vjik\TelegramBot\Api\Type\Game\Game;
use Vjik\TelegramBot\Api\Type\Payment\Invoice;
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
        public ?Chat $chat = null,
        public ?int $messageId = null,
        public ?LinkPreviewOptions $linkPreviewOptions = null,
        public ?Animation $animation = null,
        public ?Audio $audio = null,
        public ?Document $document = null,
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
    ) {
    }

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            array_key_exists('origin', $result)
                ? MessageOriginFactory::fromTelegramResult($result['origin'])
                : throw new NotFoundKeyInResultException('origin'),
            array_key_exists('chat', $result)
                ? Chat::fromTelegramResult($result['chat'])
                : null,
            ValueHelper::getIntegerOrNull($result, 'message_id'),
            array_key_exists('link_preview_options', $result)
                ? LinkPreviewOptions::fromTelegramResult($result['link_preview_options'])
                : null,
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
            array_key_exists('giveaway', $result)
                ? Giveaway::fromTelegramResult($result['giveaway'])
                : null,
            array_key_exists('giveaway_winners', $result)
                ? GiveawayWinners::fromTelegramResult($result['giveaway_winners'])
                : null,
            array_key_exists('invoice', $result)
                ? Invoice::fromTelegramResult($result['invoice'])
                : null,
            array_key_exists('location', $result)
                ? Location::fromTelegramResult($result['location'])
                : null,
            array_key_exists('poll', $result)
                ? Poll::fromTelegramResult($result['poll'])
                : null,
            array_key_exists('venue', $result)
                ? Venue::fromTelegramResult($result['venue'])
                : null,
            array_key_exists('paid_media', $result)
                ? PaidMediaInfo::fromTelegramResult($result['paid_media'])
                : null,
        );
    }
}

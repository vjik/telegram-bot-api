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

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            array_key_exists('origin', $result)
                ? MessageOriginFactory::fromTelegramResult($result['origin'], $raw)
                : throw new NotFoundKeyInResultException('origin', $raw),
            array_key_exists('chat', $result)
                ? Chat::fromTelegramResult($result['chat'], $raw)
                : null,
            ValueHelper::getIntegerOrNull($result, 'message_id', $raw),
            array_key_exists('link_preview_options', $result)
                ? LinkPreviewOptions::fromTelegramResult($result['link_preview_options'], $raw)
                : null,
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
            array_key_exists('giveaway', $result)
                ? Giveaway::fromTelegramResult($result['giveaway'], $raw)
                : null,
            array_key_exists('giveaway_winners', $result)
                ? GiveawayWinners::fromTelegramResult($result['giveaway_winners'], $raw)
                : null,
            array_key_exists('invoice', $result)
                ? Invoice::fromTelegramResult($result['invoice'], $raw)
                : null,
            array_key_exists('location', $result)
                ? Location::fromTelegramResult($result['location'], $raw)
                : null,
            array_key_exists('poll', $result)
                ? Poll::fromTelegramResult($result['poll'], $raw)
                : null,
            array_key_exists('venue', $result)
                ? Venue::fromTelegramResult($result['venue'], $raw)
                : null,
            array_key_exists('paid_media', $result)
                ? PaidMediaInfo::fromTelegramResult($result['paid_media'], $raw)
                : null,
        );
    }
}

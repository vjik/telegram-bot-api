<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Sticker;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;
use Vjik\TelegramBot\Api\Type\PhotoSize;

/**
 * @see https://core.telegram.org/bots/api#stickerset
 */
final readonly class StickerSet
{
    /**
     * @param Sticker[] $stickers
     */
    public function __construct(
        public string $name,
        public string $title,
        public string $stickerType,
        public array $stickers,
        public ?PhotoSize $thumbnail = null,
    ) {
    }

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            ValueHelper::getString($result, 'name'),
            ValueHelper::getString($result, 'title'),
            ValueHelper::getString($result, 'sticker_type'),
            ValueHelper::getArrayOfStickers($result, 'stickers'),
            array_key_exists('thumbnail', $result) ? PhotoSize::fromTelegramResult($result['thumbnail']) : null,
        );
    }
}

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

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            ValueHelper::getString($result, 'name', $raw),
            ValueHelper::getString($result, 'title', $raw),
            ValueHelper::getString($result, 'sticker_type', $raw),
            ValueHelper::getArrayOfStickers($result, 'stickers', $raw),
            array_key_exists('thumbnail', $result)
                ? PhotoSize::fromTelegramResult($result['thumbnail'], $raw)
                : null,
        );
    }
}

<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Sticker;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ArrayOfObjectsValue;
use Vjik\TelegramBot\Api\Type\PhotoSize;

/**
 * @see https://core.telegram.org/bots/api#stickerset
 *
 * @api
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
        #[ArrayOfObjectsValue(Sticker::class)]
        public array $stickers,
        public ?PhotoSize $thumbnail = null,
    ) {}
}

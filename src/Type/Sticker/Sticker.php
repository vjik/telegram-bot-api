<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Sticker;

use Vjik\TelegramBot\Api\Type\File;
use Vjik\TelegramBot\Api\Type\PhotoSize;

/**
 * @see https://core.telegram.org/bots/api#sticker
 */
final readonly class Sticker
{
    public function __construct(
        public string $fileId,
        public string $fileUniqueId,
        public string $type,
        public int $width,
        public int $height,
        public bool $isAnimated,
        public bool $isVideo,
        public ?PhotoSize $thumbnail,
        public ?string $emoji,
        public ?string $setName,
        public ?File $premiumAnimation,
        public ?MaskPosition $maskPosition,
        public ?string $customEmojiId,
        public ?bool $needsRepainting,
        public ?int $fileSize,
    ) {
    }
}

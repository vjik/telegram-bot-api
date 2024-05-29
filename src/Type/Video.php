<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#video
 */
final readonly class Video
{
    public function __construct(
        public string $fileId,
        public string $fileUniqueId,
        public int $width,
        public int $height,
        public int $duration,
        public ?PhotoSize $thumbnail,
        public ?string $fileName,
        public ?string $mimeType,
        public ?int $fileSize,
    ) {
    }
}

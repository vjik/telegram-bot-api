<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#audio
 */
final readonly class Audio
{
    public function __construct(
        public string $fileId,
        public string $fileUniqueId,
        public int $duration,
        public ?string $performer,
        public ?string $title,
        public ?string $fileName,
        public ?string $mimeType,
        public ?int $fileSize,
        public ?PhotoSize $thumbnail,
    ) {
    }
}

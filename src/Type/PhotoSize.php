<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#photosize
 */
final readonly class PhotoSize
{
    public function __construct(
        public string $fileId,
        public string $fileUniqueId,
        public int $width,
        public int $height,
        public ?int $fileSize = null,
    ) {}
}

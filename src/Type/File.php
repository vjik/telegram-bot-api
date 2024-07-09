<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#file
 */
final readonly class File
{
    public function __construct(
        public string $fileId,
        public string $fileUniqueId,
        public ?int $fileSize = null,
        public ?string $filePath = null,
    ) {}
}

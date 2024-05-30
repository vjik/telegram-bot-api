<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#file
 */
final class File
{
    public function __construct(
        public string $fileId,
        public string $fileUniqueId,
        public ?int $fileSize,
        public ?string $filePath,
    ) {
    }

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            ValueHelper::getString($result, 'file_id'),
            ValueHelper::getString($result, 'file_unique_id'),
            ValueHelper::getIntegerOrNull($result, 'file_size'),
            ValueHelper::getStringOrNull($result, 'file_path'),
        );
    }
}

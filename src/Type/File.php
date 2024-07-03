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
        public ?int $fileSize = null,
        public ?string $filePath = null,
    ) {
    }

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            ValueHelper::getString($result, 'file_id', $raw),
            ValueHelper::getString($result, 'file_unique_id', $raw),
            ValueHelper::getIntegerOrNull($result, 'file_size', $raw),
            ValueHelper::getStringOrNull($result, 'file_path', $raw),
        );
    }
}

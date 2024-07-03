<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#document
 */
final readonly class Document
{
    public function __construct(
        public string $fileId,
        public string $fileUniqueId,
        public ?PhotoSize $thumbnail = null,
        public ?string $fileName = null,
        public ?string $mimeType = null,
        public ?int $fileSize = null,
    ) {
    }

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            ValueHelper::getString($result, 'file_id', $raw),
            ValueHelper::getString($result, 'file_unique_id', $raw),
            array_key_exists('thumbnail', $result)
                ? PhotoSize::fromTelegramResult($result['thumbnail'], $raw)
                : null,
            ValueHelper::getStringOrNull($result, 'file_name', $raw),
            ValueHelper::getStringOrNull($result, 'mime_type', $raw),
            ValueHelper::getIntegerOrNull($result, 'file_size', $raw),
        );
    }
}

<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#audio
 */
final readonly class Audio
{
    public function __construct(
        public string $fileId,
        public string $fileUniqueId,
        public int $duration,
        public ?string $performer = null,
        public ?string $title = null,
        public ?string $fileName = null,
        public ?string $mimeType = null,
        public ?int $fileSize = null,
        public ?PhotoSize $thumbnail = null,
    ) {
    }

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            ValueHelper::getString($result, 'file_id', $raw),
            ValueHelper::getString($result, 'file_unique_id', $raw),
            ValueHelper::getInteger($result, 'duration', $raw),
            ValueHelper::getStringOrNull($result, 'performer', $raw),
            ValueHelper::getStringOrNull($result, 'title', $raw),
            ValueHelper::getStringOrNull($result, 'file_name', $raw),
            ValueHelper::getStringOrNull($result, 'mime_type', $raw),
            ValueHelper::getIntegerOrNull($result, 'file_size', $raw),
            array_key_exists('thumbnail', $result)
                ? PhotoSize::fromTelegramResult($result['thumbnail'], $raw)
                : null,
        );
    }
}

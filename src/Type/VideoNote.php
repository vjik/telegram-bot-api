<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#videonote
 */
final readonly class VideoNote
{
    public function __construct(
        public string $fileId,
        public string $fileUniqueId,
        public int $length,
        public int $duration,
        public ?PhotoSize $thumbnail = null,
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
            ValueHelper::getInteger($result, 'length', $raw),
            ValueHelper::getInteger($result, 'duration', $raw),
            array_key_exists('thumbnail', $result)
                ? PhotoSize::fromTelegramResult($result['thumbnail'], $raw)
                : null,
            ValueHelper::getIntegerOrNull($result, 'file_size', $raw),
        );
    }
}

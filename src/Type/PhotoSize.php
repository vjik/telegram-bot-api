<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

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
        public ?int $fileSize,
    ) {
    }

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            ValueHelper::getString($result, 'file_id'),
            ValueHelper::getString($result, 'file_unique_id'),
            ValueHelper::getInteger($result, 'width'),
            ValueHelper::getInteger($result, 'height'),
            ValueHelper::getIntegerOrNull($result, 'file_size'),
        );
    }
}

<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Psalm\Internal\Type\ParseTree\Value;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#voice
 */
final readonly class Voice
{
    public function __construct(
        public string $fileId,
        public string $fileUniqueId,
        public int $duration,
        public ?string $mimeType,
        public ?int $fileSize,
    ) {
    }

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            ValueHelper::getString($result, 'file_id'),
            ValueHelper::getString($result, 'file_unique_id'),
            ValueHelper::getInteger($result, 'duration'),
            ValueHelper::getStringOrNull($result, 'mime_type'),
            ValueHelper::getIntegerOrNull($result, 'file_size'),
        );
    }
}

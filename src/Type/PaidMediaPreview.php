<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#paidmediapreview
 */
final readonly class PaidMediaPreview implements PaidMedia
{
    public function __construct(
        public ?int $width = null,
        public ?int $height = null,
        public ?int $duration = null,
    ) {
    }

    public function getType(): string
    {
        return 'preview';
    }

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            ValueHelper::getIntegerOrNull($result, 'width', $raw),
            ValueHelper::getIntegerOrNull($result, 'height', $raw),
            ValueHelper::getIntegerOrNull($result, 'duration', $raw),
        );
    }
}

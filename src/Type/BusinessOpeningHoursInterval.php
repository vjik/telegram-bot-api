<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#businessopeninghoursinterval
 */
final readonly class BusinessOpeningHoursInterval
{
    public function __construct(
        public int $openingMinute,
        public int $closingMinute,
    ) {
    }

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            ValueHelper::getInteger($result, 'opening_minute', $raw),
            ValueHelper::getInteger($result, 'closing_minute', $raw)
        );
    }
}

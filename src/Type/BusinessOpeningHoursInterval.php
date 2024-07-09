<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#businessopeninghoursinterval
 */
final readonly class BusinessOpeningHoursInterval
{
    public function __construct(
        public int $openingMinute,
        public int $closingMinute,
    ) {}
}

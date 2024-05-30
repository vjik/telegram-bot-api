<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#businessopeninghours
 */
final readonly class BusinessOpeningHours
{
    /**
     * @param BusinessOpeningHoursInterval[] $openingHours
     */
    public function __construct(
        public string $timeZoneName,
        public array $openingHours
    ) {
    }

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            ValueHelper::getString($result, 'time_zone_name'),
            ValueHelper::getArrayOfBusinessOpeningHoursIntervals($result, 'business_hours')
        );
    }
}

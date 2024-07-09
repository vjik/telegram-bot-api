<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ArrayOfObjectsValue;

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
        #[ArrayOfObjectsValue(BusinessOpeningHoursInterval::class)]
        public array $openingHours,
    ) {}
}

<?php

declare(strict_types=1);

namespace Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\BusinessOpeningHours;
use Vjik\TelegramBot\Api\Type\BusinessOpeningHoursInterval;

final class BusinessOpeningHoursTest extends TestCase
{
    public function testBase(): void
    {
        $interval = new BusinessOpeningHoursInterval(10, 100);
        $businessOpeningHours = new BusinessOpeningHours(
            'Europe/Moscow',
            [$interval],
        );

        $this->assertSame('Europe/Moscow', $businessOpeningHours->timeZoneName);
        $this->assertSame([$interval], $businessOpeningHours->openingHours);
    }

    public function testFromTelegramResult(): void
    {
        $businessOpeningHours = BusinessOpeningHours::fromTelegramResult([
            'time_zone_name' => 'Europe/Moscow',
            'opening_hours' => [
                [
                    'opening_minute' => 10,
                    'closing_minute' => 100,
                ],
            ],
        ]);

        $this->assertSame('Europe/Moscow', $businessOpeningHours->timeZoneName);

        $this->assertCount(1, $businessOpeningHours->openingHours);
        $this->assertInstanceOf(BusinessOpeningHoursInterval::class, $businessOpeningHours->openingHours[0]);
        $this->assertSame(10, $businessOpeningHours->openingHours[0]->openingMinute);
        $this->assertSame(100, $businessOpeningHours->openingHours[0]->closingMinute);
    }
}

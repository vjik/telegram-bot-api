<?php

declare(strict_types=1);

namespace Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\BusinessOpeningHoursInterval;

final class BusinessOpeningHoursIntervalTest extends TestCase
{
    public function testBase(): void
    {
        $interval = new BusinessOpeningHoursInterval(10, 100);

        $this->assertSame(10, $interval->openingMinute);
        $this->assertSame(100, $interval->closingMinute);
    }

    public function testFromTelegramResult(): void
    {
        $interval = BusinessOpeningHoursInterval::fromTelegramResult([
            'opening_minute' => 10,
            'closing_minute' => 100,
        ]);

        $this->assertSame(10, $interval->openingMinute);
        $this->assertSame(100, $interval->closingMinute);
    }
}

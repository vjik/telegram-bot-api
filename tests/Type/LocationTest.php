<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\Location;

final class LocationTest extends TestCase
{
    public function testBase(): void
    {
        $location = new Location(1.234, 5.678);

        $this->assertSame(1.234, $location->latitude);
        $this->assertSame(5.678, $location->longitude);
        $this->assertNull($location->horizontalAccuracy);
        $this->assertNull($location->livePeriod);
        $this->assertNull($location->heading);
        $this->assertNull($location->proximityAlertRadius);
    }

    public function testFromTelegramResult(): void
    {
        $location = Location::fromTelegramResult([
            'latitude' => 1.234,
            'longitude' => 5.678,
            'horizontal_accuracy' => 0.1,
            'live_period' => 60,
            'heading' => 90,
            'proximity_alert_radius' => 100,
        ]);

        $this->assertSame(1.234, $location->latitude);
        $this->assertSame(5.678, $location->longitude);
        $this->assertSame(0.1, $location->horizontalAccuracy);
        $this->assertSame(60, $location->livePeriod);
        $this->assertSame(90, $location->heading);
        $this->assertSame(100, $location->proximityAlertRadius);
    }
}

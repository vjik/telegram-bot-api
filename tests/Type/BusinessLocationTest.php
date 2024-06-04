<?php

declare(strict_types=1);

namespace Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\BusinessLocation;
use Vjik\TelegramBot\Api\Type\Location;

final class BusinessLocationTest extends TestCase
{
    public function testBase(): void
    {
        $location = new BusinessLocation('street 7');

        $this->assertSame('street 7', $location->address);
        $this->assertNull($location->location);
    }

    public function testFromTelegramResult(): void
    {
        $location = BusinessLocation::fromTelegramResult([
            'address' => 'street 7',
            'location' => [
                'latitude' => 23.42,
                'longitude' => 42.23,
            ],
        ]);

        $this->assertSame('street 7', $location->address);

        $this->assertInstanceOf(Location::class, $location->location);
        $this->assertSame(23.42, $location->location->latitude);
    }
}

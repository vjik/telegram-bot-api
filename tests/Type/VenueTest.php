<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\Location;
use Vjik\TelegramBot\Api\Type\Venue;

final class VenueTest extends TestCase
{
    public function testBase(): void
    {
        $location = new Location(1.1, 2.2);
        $venue = new Venue($location, 'Title', 'Address');

        $this->assertSame($location, $venue->location);
        $this->assertSame('Title', $venue->title);
        $this->assertSame('Address', $venue->address);
        $this->assertNull($venue->foursquareId);
        $this->assertNull($venue->foursquareType);
        $this->assertNull($venue->googlePlaceId);
        $this->assertNull($venue->googlePlaceType);
    }

    public function testFromTelegramResult(): void
    {
        $venue = (new ObjectFactory())->create([
            'location' => [
                'latitude' => 1.1,
                'longitude' => 2.2,
            ],
            'title' => 'Title',
            'address' => 'Address',
            'foursquare_id' => 'FoursquareId',
            'foursquare_type' => 'FoursquareType',
            'google_place_id' => 'GooglePlaceId',
            'google_place_type' => 'GooglePlaceType',
        ], null, Venue::class);

        $this->assertSame(1.1, $venue->location->latitude);
        $this->assertSame(2.2, $venue->location->longitude);

        $this->assertSame('Title', $venue->title);
        $this->assertSame('Address', $venue->address);
        $this->assertSame('FoursquareId', $venue->foursquareId);
        $this->assertSame('FoursquareType', $venue->foursquareType);
        $this->assertSame('GooglePlaceId', $venue->googlePlaceId);
        $this->assertSame('GooglePlaceType', $venue->googlePlaceType);
    }
}

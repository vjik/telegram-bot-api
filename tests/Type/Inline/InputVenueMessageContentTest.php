<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Inline;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\Inline\InputVenueMessageContent;

final class InputVenueMessageContentTest extends TestCase
{
    public function testBase(): void
    {
        $type = new InputVenueMessageContent(1.1, 2.2, 'Title', 'Address');

        $this->assertSame(1.1, $type->latitude);
        $this->assertSame(2.2, $type->longitude);
        $this->assertSame('Title', $type->title);
        $this->assertSame('Address', $type->address);
        $this->assertNull($type->foursquareId);
        $this->assertNull($type->foursquareType);
        $this->assertNull($type->googlePlaceId);
        $this->assertNull($type->googlePlaceType);
        $this->assertSame(
            [
                'latitude' => 1.1,
                'longitude' => 2.2,
                'title' => 'Title',
                'address' => 'Address',
            ],
            $type->toRequestArray(),
        );
    }

    public function testFull(): void
    {
        $type = new InputVenueMessageContent(1.1, 2.2, 'Title', 'Address', 'fid', 'ftype', 'gid', 'gtype');

        $this->assertSame(1.1, $type->latitude);
        $this->assertSame(2.2, $type->longitude);
        $this->assertSame('Title', $type->title);
        $this->assertSame('Address', $type->address);
        $this->assertSame('fid', $type->foursquareId);
        $this->assertSame('ftype', $type->foursquareType);
        $this->assertSame('gid', $type->googlePlaceId);
        $this->assertSame('gtype', $type->googlePlaceType);
        $this->assertSame(
            [
                'latitude' => 1.1,
                'longitude' => 2.2,
                'title' => 'Title',
                'address' => 'Address',
                'foursquare_id' => 'fid',
                'foursquare_type' => 'ftype',
                'google_place_id' => 'gid',
                'google_place_type' => 'gtype',
            ],
            $type->toRequestArray(),
        );
    }
}

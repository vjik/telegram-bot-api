<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\ChatLocation;
use Vjik\TelegramBot\Api\Type\Location;

use function PHPUnit\Framework\assertSame;

final class ChatLocationTest extends TestCase
{
    public function testBase(): void
    {
        $location = new Location(1.1, 2.2);
        $chatLocation = new ChatLocation($location, 'Test');

        assertSame($location, $chatLocation->location);
        assertSame('Test', $chatLocation->address);
    }

    public function testFromTelegramResult(): void
    {
        $result = [
            'location' => [
                'latitude' => 1.1,
                'longitude' => 2.2,
            ],
            'address' => 'Test',
        ];

        $chatLocation = (new ObjectFactory())->create($result, null, ChatLocation::class);

        assertSame(1.1, $chatLocation->location->latitude);
        assertSame('Test', $chatLocation->address);
    }
}

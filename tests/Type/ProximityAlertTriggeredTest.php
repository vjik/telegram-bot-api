<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\ProximityAlertTriggered;
use Vjik\TelegramBot\Api\Type\User;

use function PHPUnit\Framework\assertSame;

final class ProximityAlertTriggeredTest extends TestCase
{
    public function testBase(): void
    {
        $traveler = new User(1, true, 'mybot');
        $watcher = new User(2, false, 'Mike');
        $proximityAlertTriggered = new ProximityAlertTriggered($traveler, $watcher, 12);

        assertSame($traveler, $proximityAlertTriggered->traveler);
        assertSame($watcher, $proximityAlertTriggered->watcher);
        assertSame(12, $proximityAlertTriggered->distance);
    }

    public function testFromTelegramResult(): void
    {
        $proximityAlertTriggered = (new ObjectFactory())->create([
            'traveler' => [
                'id' => 1,
                'is_bot' => true,
                'first_name' => 'mybot',
            ],
            'watcher' => [
                'id' => 2,
                'is_bot' => false,
                'first_name' => 'Mike',
            ],
            'distance' => 12,
        ], null, ProximityAlertTriggered::class);

        assertSame(1, $proximityAlertTriggered->traveler->id);
        assertSame(2, $proximityAlertTriggered->watcher->id);
        assertSame(12, $proximityAlertTriggered->distance);
    }
}

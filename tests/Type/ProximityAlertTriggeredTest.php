<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\ProximityAlertTriggered;
use Vjik\TelegramBot\Api\Type\User;

final class ProximityAlertTriggeredTest extends TestCase
{
    public function testBase(): void
    {
        $traveler = new User(1, true, 'mybot');
        $watcher = new User(2, false, 'Mike');
        $proximityAlertTriggered = new ProximityAlertTriggered($traveler, $watcher, 12);

        $this->assertSame($traveler, $proximityAlertTriggered->traveler);
        $this->assertSame($watcher, $proximityAlertTriggered->watcher);
        $this->assertSame(12, $proximityAlertTriggered->distance);
    }

    public function testFromTelegramResult(): void
    {
        $proximityAlertTriggered = ProximityAlertTriggered::fromTelegramResult([
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
        ]);

        $this->assertSame(1, $proximityAlertTriggered->traveler->id);
        $this->assertSame(2, $proximityAlertTriggered->watcher->id);
        $this->assertSame(12, $proximityAlertTriggered->distance);
    }
}

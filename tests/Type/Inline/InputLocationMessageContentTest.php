<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Inline;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\Inline\InputLocationMessageContent;

final class InputLocationMessageContentTest extends TestCase
{
    public function testBase(): void
    {
        $type = new InputLocationMessageContent(1.1, 2.2);

        $this->assertSame(1.1, $type->latitude);
        $this->assertSame(2.2, $type->longitude);
        $this->assertNull($type->horizontalAccuracy);
        $this->assertNull($type->livePeriod);
        $this->assertNull($type->heading);
        $this->assertNull($type->proximityAlertRadius);
        $this->assertSame(
            [
                'latitude' => 1.1,
                'longitude' => 2.2,
            ],
            $type->toRequestArray(),
        );
    }

    public function testFull(): void
    {
        $type = new InputLocationMessageContent(1.1, 2.2, 3.4, 60, 90, 100);

        $this->assertSame(1.1, $type->latitude);
        $this->assertSame(2.2, $type->longitude);
        $this->assertSame(3.4, $type->horizontalAccuracy);
        $this->assertSame(60, $type->livePeriod);
        $this->assertSame(90, $type->heading);
        $this->assertSame(100, $type->proximityAlertRadius);
        $this->assertSame(
            [
                'latitude' => 1.1,
                'longitude' => 2.2,
                'horizontal_accuracy' => 3.4,
                'live_period' => 60,
                'heading' => 90,
                'proximity_alert_radius' => 100,
            ],
            $type->toRequestArray(),
        );
    }
}

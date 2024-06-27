<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\BackgroundFillGradient;

final class BackgroundFillGradientTest extends TestCase
{
    public function testBase(): void
    {
        $fill = new BackgroundFillGradient(0x000000, 0xFFFFFF, 17);

        $this->assertSame('gradient', $fill->getType());
        $this->assertSame(0x000000, $fill->topColor);
        $this->assertSame(0xFFFFFF, $fill->bottomColor);
        $this->assertSame(17, $fill->rotationAngle);
    }

    public function testFromTelegramResult(): void
    {
        $fill = BackgroundFillGradient::fromTelegramResult([
            'type' => 'gradient',
            'top_color' => 0x000000,
            'bottom_color' => 0xFFFFFF,
            'rotation_angle' => 17,
        ]);

        $this->assertSame('gradient', $fill->getType());
        $this->assertSame(0x000000, $fill->topColor);
        $this->assertSame(0xFFFFFF, $fill->bottomColor);
        $this->assertSame(17, $fill->rotationAngle);
    }
}

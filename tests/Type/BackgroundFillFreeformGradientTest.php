<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\BackgroundFillFreeformGradient;

final class BackgroundFillFreeformGradientTest extends TestCase
{
    public function testBase(): void
    {
        $fill = new BackgroundFillFreeformGradient([0x000000, 0xFFFFFF]);

        $this->assertSame('freeform_gradient', $fill->getType());
        $this->assertSame([0x000000, 0xFFFFFF], $fill->colors);
    }

    public function testFromTelegramResult(): void
    {
        $fill = BackgroundFillFreeformGradient::fromTelegramResult([
            'type' => 'freeform_gradient',
            'colors' => [0x000000, 0xFFFFFF],
        ]);

        $this->assertSame('freeform_gradient', $fill->getType());
        $this->assertSame([0x000000, 0xFFFFFF], $fill->colors);
    }
}

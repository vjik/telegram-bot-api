<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\BackgroundFillFreeformGradient;

use function PHPUnit\Framework\assertSame;

final class BackgroundFillFreeformGradientTest extends TestCase
{
    public function testBase(): void
    {
        $fill = new BackgroundFillFreeformGradient([0x000000, 0xFFFFFF]);

        assertSame('freeform_gradient', $fill->getType());
        assertSame([0x000000, 0xFFFFFF], $fill->colors);
    }

    public function testFromTelegramResult(): void
    {
        $fill = (new ObjectFactory())->create([
            'type' => 'freeform_gradient',
            'colors' => [0x000000, 0xFFFFFF],
        ], null, BackgroundFillFreeformGradient::class);

        assertSame('freeform_gradient', $fill->getType());
        assertSame([0x000000, 0xFFFFFF], $fill->colors);
    }
}

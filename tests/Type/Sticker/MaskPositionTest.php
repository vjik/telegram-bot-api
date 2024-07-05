<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Sticker;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\Sticker\MaskPosition;

final class MaskPositionTest extends TestCase
{
    public function testMaskPosition(): void
    {
        $maskPosition = new MaskPosition(
            'forehead',
            0.5,
            0.6,
            0.7
        );

        $this->assertSame('forehead', $maskPosition->point);
        $this->assertSame(0.5, $maskPosition->xShift);
        $this->assertSame(0.6, $maskPosition->yShift);
        $this->assertSame(0.7, $maskPosition->scale);
        $this->assertSame(
            [
                'point' => 'forehead',
                'x_shift' => 0.5,
                'y_shift' => 0.6,
                'scale' => 0.7,
            ],
            $maskPosition->toRequestArray(),
        );
    }

    public function testFromTelegramResult(): void
    {
        $maskPosition = (new ObjectFactory())->create([
            'point' => 'forehead',
            'x_shift' => 0.5,
            'y_shift' => 0.6,
            'scale' => 0.7,
        ], null, MaskPosition::class);

        $this->assertSame('forehead', $maskPosition->point);
        $this->assertSame(0.5, $maskPosition->xShift);
        $this->assertSame(0.6, $maskPosition->yShift);
        $this->assertSame(0.7, $maskPosition->scale);
    }
}

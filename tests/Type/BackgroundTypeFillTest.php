<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\BackgroundFillSolid;
use Vjik\TelegramBot\Api\Type\BackgroundTypeFill;

final class BackgroundTypeFillTest extends TestCase
{
    public function testBase(): void
    {
        $type = new BackgroundTypeFill(
            new BackgroundFillSolid(0x000000),
            95
        );

        $this->assertSame('fill', $type->getType());
        $this->assertInstanceOf(BackgroundFillSolid::class, $type->fill);
        $this->assertSame(0x000000, $type->fill->color);
        $this->assertSame(95, $type->darkThemeDimming);
    }

    public function testFromTelegramResult(): void
    {
        $type = (new ObjectFactory())->create([
            'type' => 'fill',
            'fill' => [
                'type' => 'solid',
                'color' => 0x000000
            ],
            'dark_theme_dimming' => 95,
        ], null, BackgroundTypeFill::class);

        $this->assertSame('fill', $type->getType());
        $this->assertInstanceOf(BackgroundFillSolid::class, $type->fill);
        $this->assertSame(0x000000, $type->fill->color);
        $this->assertSame(95, $type->darkThemeDimming);
    }
}

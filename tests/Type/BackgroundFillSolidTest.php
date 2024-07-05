<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\BackgroundFillSolid;

final class BackgroundFillSolidTest extends TestCase
{
    public function testBase(): void
    {
        $fill = new BackgroundFillSolid(0x000000);

        $this->assertSame('solid', $fill->getType());
        $this->assertSame(0x000000, $fill->color);
    }

    public function testFromTelegramResult(): void
    {
        $fill = (new ObjectFactory())->create([
            'type' => 'solid',
            'color' => 0x000000,
        ], null, BackgroundFillSolid::class);

        $this->assertSame('solid', $fill->getType());
        $this->assertSame(0x000000, $fill->color);
    }
}

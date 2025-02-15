<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\BackgroundFillSolid;

use function PHPUnit\Framework\assertSame;

final class BackgroundFillSolidTest extends TestCase
{
    public function testBase(): void
    {
        $fill = new BackgroundFillSolid(0x000000);

        assertSame('solid', $fill->getType());
        assertSame(0x000000, $fill->color);
    }

    public function testFromTelegramResult(): void
    {
        $fill = (new ObjectFactory())->create([
            'type' => 'solid',
            'color' => 0x000000,
        ], null, BackgroundFillSolid::class);

        assertSame('solid', $fill->getType());
        assertSame(0x000000, $fill->color);
    }
}

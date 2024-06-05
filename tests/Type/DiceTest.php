<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\Dice;

final class DiceTest extends TestCase
{
    public function testBase(): void
    {
        $dice = new Dice('🎲', 6);

        $this->assertSame('🎲', $dice->emoji);
        $this->assertSame(6, $dice->value);
    }

    public function testFromTelegramResult(): void
    {
        $dice = Dice::fromTelegramResult([
            'emoji' => '🎲',
            'value' => 6,
        ]);

        $this->assertSame('🎲', $dice->emoji);
        $this->assertSame(6, $dice->value);
    }
}

<?php

declare(strict_types=1);

namespace Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\BotName;

final class BotNameTest extends TestCase
{
    public function testBase(): void
    {
        $name = new BotName('test');

        $this->assertSame('test', $name->name);
    }

    public function testFromTelegramResult(): void
    {
        $name = BotName::fromTelegramResult([
            'name' => 'test',
        ]);

        $this->assertSame('test', $name->name);
    }
}

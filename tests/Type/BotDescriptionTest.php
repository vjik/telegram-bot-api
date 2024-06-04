<?php

declare(strict_types=1);

namespace Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\BotDescription;

final class BotDescriptionTest extends TestCase
{
    public function testBase(): void
    {
        $description = new BotDescription('test');

        $this->assertSame('test', $description->description);
    }

    public function testFromTelegramResult(): void
    {
        $description = BotDescription::fromTelegramResult([
            'description' => 'test',
        ]);

        $this->assertSame('test', $description->description);
    }
}

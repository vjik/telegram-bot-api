<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\BotShortDescription;

final class BotShortDescriptionTest extends TestCase
{
    public function testBase(): void
    {
        $description = new BotShortDescription('test');

        $this->assertSame('test', $description->shortDescription);
    }

    public function testFromTelegramResult(): void
    {
        $description = BotShortDescription::fromTelegramResult([
            'short_description' => 'test',
        ]);

        $this->assertSame('test', $description->shortDescription);
    }
}

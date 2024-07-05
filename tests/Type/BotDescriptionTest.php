<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
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
        $description = (new ObjectFactory())->create([
            'description' => 'test',
        ], null, BotDescription::class);

        $this->assertSame('test', $description->description);
    }
}

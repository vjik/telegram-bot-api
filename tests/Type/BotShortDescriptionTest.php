<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
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
        $description = (new ObjectFactory())->create([
            'short_description' => 'test',
        ], null, BotShortDescription::class);

        $this->assertSame('test', $description->shortDescription);
    }
}

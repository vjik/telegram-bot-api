<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
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
        $name = (new ObjectFactory())->create([
            'name' => 'test',
        ], null, BotName::class);

        $this->assertSame('test', $name->name);
    }
}

<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\Type\MenuButtonDefault;

final class MenuButtonDefaultTest extends TestCase
{
    public function testBase(): void
    {
        $button = new MenuButtonDefault();

        $this->assertSame('default', $button->getType());

        $this->assertSame(['type' => 'default'], $button->toRequestArray());
    }

    public function testFromTelegramResult(): void
    {
        $button = MenuButtonDefault::fromTelegramResult([
            'type' => 'default',
        ]);

        $this->assertSame('default', $button->getType());
    }

    public function testFromTelegramResultWithInvalidResult(): void
    {
        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Expected result as array. Got "string".');
        MenuButtonDefault::fromTelegramResult('hello');
    }
}

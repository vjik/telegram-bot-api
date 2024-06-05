<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\Type\MenuButtonCommands;

final class MenuButtonCommandsTest extends TestCase
{
    public function testBase(): void
    {
        $button = new MenuButtonCommands();

        $this->assertSame('commands', $button->getType());

        $this->assertSame(['type' => 'commands'], $button->toRequestArray());
    }

    public function testFromTelegramResult(): void
    {
        $button = MenuButtonCommands::fromTelegramResult([
            'type' => 'commands',
        ]);

        $this->assertSame('commands', $button->getType());
    }

    public function testFromTelegramResultWithInvalidResult(): void
    {
        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Expected result as array. Got "string".');
        MenuButtonCommands::fromTelegramResult('hello');
    }
}

<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\MenuButtonCommands;

use function PHPUnit\Framework\assertSame;

final class MenuButtonCommandsTest extends TestCase
{
    public function testBase(): void
    {
        $button = new MenuButtonCommands();

        assertSame('commands', $button->getType());

        assertSame(['type' => 'commands'], $button->toRequestArray());
    }

    public function testFromTelegramResult(): void
    {
        $button = (new ObjectFactory())->create([
            'type' => 'commands',
        ], null, MenuButtonCommands::class);

        assertSame('commands', $button->getType());
    }

    public function testFromTelegramResultWithInvalidResult(): void
    {
        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Invalid type of value. Expected type is "array", but got "string".');
        (new ObjectFactory())->create('hello', null, MenuButtonCommands::class);
    }
}

<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\BotCommand;

use function PHPUnit\Framework\assertSame;

final class BotCommandTest extends TestCase
{
    public function testBase(): void
    {
        $botCommand = new BotCommand('start', 'Start command');

        assertSame('start', $botCommand->command);
        assertSame('Start command', $botCommand->description);

        assertSame(
            [
                'command' => 'start',
                'description' => 'Start command',
            ],
            $botCommand->toRequestArray(),
        );
    }

    public function testFromTelegramResult(): void
    {
        $botCommand = (new ObjectFactory())->create([
            'command' => 'start',
            'description' => 'Start command',
        ], null, BotCommand::class);

        assertSame('start', $botCommand->command);
        assertSame('Start command', $botCommand->description);
    }
}

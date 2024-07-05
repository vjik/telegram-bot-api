<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\BotCommand;

final class BotCommandTest extends TestCase
{
    public function testBase(): void
    {
        $botCommand = new BotCommand('start', 'Start command');

        $this->assertSame('start', $botCommand->command);
        $this->assertSame('Start command', $botCommand->description);

        $this->assertSame(
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

        $this->assertSame('start', $botCommand->command);
        $this->assertSame('Start command', $botCommand->description);
    }
}

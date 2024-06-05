<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Game;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\Game\CallbackGame;

final class CallbackGameTest extends TestCase
{
    public function testBase(): void
    {
        $callbackGame = new CallbackGame();

        $this->assertSame([], $callbackGame->toRequestArray());
    }

    public function testFromTelegramResult(): void
    {
        $callbackGame = CallbackGame::fromTelegramResult([]);

        $this->assertInstanceOf(CallbackGame::class, $callbackGame);
    }
}

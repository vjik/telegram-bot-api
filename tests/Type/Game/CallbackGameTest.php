<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Game;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\Game\CallbackGame;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class CallbackGameTest extends TestCase
{
    public function testBase(): void
    {
        $callbackGame = new CallbackGame();

        assertSame([], $callbackGame->toRequestArray());
    }

    public function testFromTelegramResult(): void
    {
        $callbackGame = (new ObjectFactory())->create([], null, CallbackGame::class);

        assertInstanceOf(CallbackGame::class, $callbackGame);
    }
}

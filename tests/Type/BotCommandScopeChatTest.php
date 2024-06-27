<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\BotCommandScopeChat;

final class BotCommandScopeChatTest extends TestCase
{
    public function testBase(): void
    {
        $scope = new BotCommandScopeChat(1);

        $this->assertSame('chat', $scope->getType());
        $this->assertSame(1, $scope->chatId);

        $this->assertSame(
            [
                'type' => 'chat',
                'chat_id' => 1,
            ],
            $scope->toRequestArray(),
        );
    }
}

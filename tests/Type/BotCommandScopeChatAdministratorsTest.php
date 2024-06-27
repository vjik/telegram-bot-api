<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\BotCommandScopeChatAdministrators;

final class BotCommandScopeChatAdministratorsTest extends TestCase
{
    public function testBase(): void
    {
        $scope = new BotCommandScopeChatAdministrators(1);

        $this->assertSame('chat_administrators', $scope->getType());
        $this->assertSame(1, $scope->chatId);

        $this->assertSame(
            [
                'type' => 'chat_administrators',
                'chat_id' => 1,
            ],
            $scope->toRequestArray(),
        );
    }
}

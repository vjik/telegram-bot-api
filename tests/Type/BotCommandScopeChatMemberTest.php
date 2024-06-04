<?php

declare(strict_types=1);

namespace Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\BotCommandScopeChatMember;

final class BotCommandScopeChatMemberTest extends TestCase
{
    public function testBase(): void
    {
        $scope = new BotCommandScopeChatMember(1, 2);

        $this->assertSame('chat_member', $scope->getType());
        $this->assertSame(1, $scope->chatId);
        $this->assertSame(2, $scope->userId);

        $this->assertSame(
            [
                'type' => 'chat_member',
                'chat_id' => 1,
                'user_id' => 2,
            ],
            $scope->toRequestArray(),
        );
    }
}

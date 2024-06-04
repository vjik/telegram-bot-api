<?php

declare(strict_types=1);

namespace Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\BotCommandScopeAllGroupChats;

final class BotCommandScopeAllGroupChatsTest extends TestCase
{
    public function testBase(): void
    {
        $scope = new BotCommandScopeAllGroupChats();

        $this->assertSame('all_group_chats', $scope->getType());

        $this->assertSame(
            [
                'type' => 'all_group_chats',
            ],
            $scope->toRequestArray(),
        );
    }
}

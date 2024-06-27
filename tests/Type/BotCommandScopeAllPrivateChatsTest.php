<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\BotCommandScopeAllPrivateChats;

final class BotCommandScopeAllPrivateChatsTest extends TestCase
{
    public function testBase(): void
    {
        $scope = new BotCommandScopeAllPrivateChats();

        $this->assertSame('all_private_chats', $scope->getType());

        $this->assertSame(
            [
                'type' => 'all_private_chats',
            ],
            $scope->toRequestArray(),
        );
    }
}

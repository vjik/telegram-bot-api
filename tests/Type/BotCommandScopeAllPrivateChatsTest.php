<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\BotCommandScopeAllPrivateChats;

use function PHPUnit\Framework\assertSame;

final class BotCommandScopeAllPrivateChatsTest extends TestCase
{
    public function testBase(): void
    {
        $scope = new BotCommandScopeAllPrivateChats();

        assertSame('all_private_chats', $scope->getType());

        assertSame(
            [
                'type' => 'all_private_chats',
            ],
            $scope->toRequestArray(),
        );
    }
}

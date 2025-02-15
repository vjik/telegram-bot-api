<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\BotCommandScopeAllGroupChats;

use function PHPUnit\Framework\assertSame;

final class BotCommandScopeAllGroupChatsTest extends TestCase
{
    public function testBase(): void
    {
        $scope = new BotCommandScopeAllGroupChats();

        assertSame('all_group_chats', $scope->getType());

        assertSame(
            [
                'type' => 'all_group_chats',
            ],
            $scope->toRequestArray(),
        );
    }
}

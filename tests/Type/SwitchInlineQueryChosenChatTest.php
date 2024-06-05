<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\SwitchInlineQueryChosenChat;

final class SwitchInlineQueryChosenChatTest extends TestCase
{
    public function testBase(): void
    {
        $switchInlineQueryChosenChat = new SwitchInlineQueryChosenChat();

        $this->assertNull($switchInlineQueryChosenChat->query);
        $this->assertNull($switchInlineQueryChosenChat->allowUserChats);
        $this->assertNull($switchInlineQueryChosenChat->allowBotChats);
        $this->assertNull($switchInlineQueryChosenChat->allowGroupChats);
        $this->assertNull($switchInlineQueryChosenChat->allowChannelChats);

        $this->assertSame([], $switchInlineQueryChosenChat->toRequestArray());
    }

    public function testFilled(): void
    {
        $switchInlineQueryChosenChat = new SwitchInlineQueryChosenChat(
            'q1',
            true,
            true,
            false,
            false,
        );

        $this->assertSame('q1', $switchInlineQueryChosenChat->query);
        $this->assertTrue($switchInlineQueryChosenChat->allowUserChats);
        $this->assertTrue($switchInlineQueryChosenChat->allowBotChats);
        $this->assertFalse($switchInlineQueryChosenChat->allowGroupChats);
        $this->assertFalse($switchInlineQueryChosenChat->allowChannelChats);

        $this->assertSame(
            [
                'query' => 'q1',
                'allow_user_chats' => true,
                'allow_bot_chats' => true,
                'allow_group_chats' => false,
                'allow_channel_chats' => false,
            ],
            $switchInlineQueryChosenChat->toRequestArray(),
        );
    }

    public function testFromTelegramResult(): void
    {
        $switchInlineQueryChosenChat = SwitchInlineQueryChosenChat::fromTelegramResult([
            'query' => 'q1',
            'allow_user_chats' => true,
            'allow_bot_chats' => true,
            'allow_group_chats' => false,
            'allow_channel_chats' => false,
        ]);

        $this->assertSame('q1', $switchInlineQueryChosenChat->query);
        $this->assertTrue($switchInlineQueryChosenChat->allowUserChats);
        $this->assertTrue($switchInlineQueryChosenChat->allowBotChats);
        $this->assertFalse($switchInlineQueryChosenChat->allowGroupChats);
        $this->assertFalse($switchInlineQueryChosenChat->allowChannelChats);
    }
}

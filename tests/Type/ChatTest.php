<?php

declare(strict_types=1);

namespace Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\Chat;

final class ChatTest extends TestCase
{
    public function testBase(): void
    {
        $chat = new Chat(1, 'private');

        $this->assertSame(1, $chat->id);
        $this->assertSame('private', $chat->type);
        $this->assertNull($chat->title);
        $this->assertNull($chat->username);
        $this->assertNull($chat->firstName);
        $this->assertNull($chat->lastName);
        $this->assertNull($chat->isForum);
    }

    public function testFromTelegramResult(): void
    {
        $chat = Chat::fromTelegramResult([
            'id' => 1,
            'type' => 'private',
            'title' => 'Title',
            'username' => 'username',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'is_forum' => true,
        ]);

        $this->assertSame(1, $chat->id);
        $this->assertSame('private', $chat->type);
        $this->assertSame('Title', $chat->title);
        $this->assertSame('username', $chat->username);
        $this->assertSame('First Name', $chat->firstName);
        $this->assertSame('Last Name', $chat->lastName);
        $this->assertTrue($chat->isForum);
    }
}

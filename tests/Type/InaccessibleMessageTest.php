<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\Chat;
use Vjik\TelegramBot\Api\Type\InaccessibleMessage;

final class InaccessibleMessageTest extends TestCase
{
    public function testBase(): void
    {
        $chat = new Chat(1, 'private');
        $inaccessibleMessage = new InaccessibleMessage($chat, 23);

        $this->assertSame($chat, $inaccessibleMessage->chat);
        $this->assertSame(23, $inaccessibleMessage->messageId);
    }

    public function testFromTelegramResult(): void
    {
        $inaccessibleMessage = InaccessibleMessage::fromTelegramResult([
            'chat' => [
                'id' => 1,
                'type' => 'private',
            ],
            'message_id' => 23,
        ]);

        $this->assertSame(1, $inaccessibleMessage->chat->id);
        $this->assertSame(23, $inaccessibleMessage->messageId);
    }
}

<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\Chat;
use Vjik\TelegramBot\Api\Type\InaccessibleMessage;

use function PHPUnit\Framework\assertSame;

final class InaccessibleMessageTest extends TestCase
{
    public function testBase(): void
    {
        $chat = new Chat(1, 'private');
        $inaccessibleMessage = new InaccessibleMessage($chat, 23);

        assertSame($chat, $inaccessibleMessage->chat);
        assertSame(23, $inaccessibleMessage->messageId);
    }

    public function testFromTelegramResult(): void
    {
        $inaccessibleMessage = (new ObjectFactory())->create([
            'chat' => [
                'id' => 1,
                'type' => 'private',
            ],
            'message_id' => 23,
        ], null, InaccessibleMessage::class);

        assertSame(1, $inaccessibleMessage->chat->id);
        assertSame(23, $inaccessibleMessage->messageId);
    }
}

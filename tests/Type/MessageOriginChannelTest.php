<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\Chat;
use Vjik\TelegramBot\Api\Type\MessageOriginChannel;

final class MessageOriginChannelTest extends TestCase
{
    public function testBase(): void
    {
        $date = new DateTimeImmutable();
        $chat = new Chat(1, 'private');
        $origin = new MessageOriginChannel($date, $chat, 12);

        $this->assertSame('channel', $origin->getType());
        $this->assertSame($date, $origin->getDate());
        $this->assertSame($date, $origin->date);
        $this->assertSame($chat, $origin->chat);
        $this->assertSame(12, $origin->messageId);
        $this->assertNull($origin->authorSignature);
    }

    public function testFromTelegramResult(): void
    {
        $origin = MessageOriginChannel::fromTelegramResult([
            'type' => 'channel',
            'date' => 12412512,
            'chat' => [
                'id' => 123,
                'type' => 'private',
            ],
            'message_id' => 12,
            'author_signature' => 'John Doe',
        ]);

        $this->assertSame('channel', $origin->getType());
        $this->assertSame(12412512, $origin->getDate()->getTimestamp());
        $this->assertSame(12412512, $origin->date->getTimestamp());
        $this->assertSame(123, $origin->chat->id);
        $this->assertSame(12, $origin->messageId);
        $this->assertSame('John Doe', $origin->authorSignature);
    }
}

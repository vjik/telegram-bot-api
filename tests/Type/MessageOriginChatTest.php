<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\Chat;
use Vjik\TelegramBot\Api\Type\MessageOriginChat;

final class MessageOriginChatTest extends TestCase
{
    public function testBase(): void
    {
        $date = new DateTimeImmutable();
        $chat = new Chat(1, 'private');
        $origin = new MessageOriginChat($date, $chat);

        $this->assertSame('chat', $origin->getType());
        $this->assertSame($date, $origin->getDate());
        $this->assertSame($date, $origin->date);
        $this->assertSame($chat, $origin->senderChat);
        $this->assertNull($origin->authorSignature);
    }

    public function testFromTelegramResult(): void
    {
        $origin = (new ObjectFactory())->create([
            'type' => 'chat',
            'date' => 12412512,
            'sender_chat' => [
                'id' => 123,
                'type' => 'private',
            ],
            'author_signature' => 'John Doe',
        ], null, MessageOriginChat::class);

        $this->assertSame('chat', $origin->getType());
        $this->assertSame(12412512, $origin->getDate()->getTimestamp());
        $this->assertSame(12412512, $origin->date->getTimestamp());
        $this->assertSame(123, $origin->senderChat->id);
        $this->assertSame('John Doe', $origin->authorSignature);
    }
}

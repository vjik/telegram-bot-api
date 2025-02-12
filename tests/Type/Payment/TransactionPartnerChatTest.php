<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Payment;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\Type\Chat;
use Vjik\TelegramBot\Api\Type\Payment\TransactionPartnerChat;
use Vjik\TelegramBot\Api\Type\Sticker\Gift;
use Vjik\TelegramBot\Api\Type\Sticker\Sticker;

final class TransactionPartnerChatTest extends TestCase
{
    public function testBase(): void
    {
        $chat = new Chat(123, 'private');
        $object = new TransactionPartnerChat($chat);

        $this->assertSame('chat', $object->getType());
        $this->assertSame($chat, $object->chat);
        $this->assertNull($object->gift);
    }

    public function testFull(): void
    {
        $chat = new Chat(123, 'private');
        $gift = new Gift(
            'test-id',
            new Sticker(
                'x1',
                'fullX1',
                'regular',
                100,
                120,
                false,
                true,
            ),
            5,
        );
        $object = new TransactionPartnerChat($chat, $gift);

        $this->assertSame('chat', $object->getType());
        $this->assertSame($chat, $object->chat);
        $this->assertSame($gift, $object->gift);
    }

    public function testFromTelegramResult(): void
    {
        $object = (new ObjectFactory())->create(
            [
                'type' => 'chat',
                'chat' => [
                    'id' => 123,
                    'type' => 'private',
                ],
                'gift' => [
                    'id' => 'test-id1',
                    'sticker' => [
                        'file_id' => 'x1',
                        'file_unique_id' => 'fullX1',
                        'type' => 'regular',
                        'width' => 100,
                        'height' => 120,
                        'is_animated' => false,
                        'is_video' => true,
                    ],
                    'star_count' => 11,
                ],
            ],
            null,
            TransactionPartnerChat::class,
        );

        $this->assertSame('chat', $object->getType());
        $this->assertSame(123, $object->chat->id);
        $this->assertSame('test-id1', $object->gift->id);
    }

    public function testFromTelegramResultWithInvalidResult(): void
    {
        $objectFactory = new ObjectFactory();

        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Invalid type of value. Expected type is "array", but got "string".');
        $objectFactory->create('hello', null, TransactionPartnerChat::class);
    }
}

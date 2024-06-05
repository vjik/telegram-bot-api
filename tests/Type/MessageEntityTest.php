<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\MessageEntity;
use Vjik\TelegramBot\Api\Type\User;

final class MessageEntityTest extends TestCase
{
    public function testCreate(): void
    {
        $messageEntity = new MessageEntity('bold', 0, 4);

        $this->assertSame('bold', $messageEntity->type);
        $this->assertSame(0, $messageEntity->offset);
        $this->assertSame(4, $messageEntity->length);
        $this->assertNull($messageEntity->url);
        $this->assertNull($messageEntity->user);
        $this->assertNull($messageEntity->language);
        $this->assertNull($messageEntity->customEmojiId);
    }

    public function testToRequestArray(): void
    {
        $messageEntity = new MessageEntity(
            'bold',
            0,
            4,
            'https://example.com/',
            new User(1, false, 'Sergei'),
            'ru',
            'x6'
        );

        $this->assertSame(
            [
                'type' => 'bold',
                'offset' => 0,
                'length' => 4,
                'url' => 'https://example.com/',
                'user' => [
                    'id' => 1,
                    'is_bot' => false,
                    'first_name' => 'Sergei',
                ],
                'language' => 'ru',
                'custom_emoji_id' => 'x6',
            ],
            $messageEntity->toRequestArray()
        );
    }

    public function testFromTelegramResult(): void
    {
        $messageEntity = MessageEntity::fromTelegramResult([
            'type' => 'bold',
            'offset' => 0,
            'length' => 4,
            'url' => 'https://example.com/',
            'user' => [
                'id' => 1,
                'is_bot' => false,
                'first_name' => 'Sergei',
            ],
            'language' => 'ru',
            'custom_emoji_id' => 'x6',
        ]);

        $this->assertSame('bold', $messageEntity->type);
        $this->assertSame(0, $messageEntity->offset);
        $this->assertSame(4, $messageEntity->length);
        $this->assertSame('https://example.com/', $messageEntity->url);

        $this->assertInstanceOf(User::class, $messageEntity->user);
        $this->assertSame(1, $messageEntity->user->id);
        $this->assertFalse($messageEntity->user->isBot);
        $this->assertSame('Sergei', $messageEntity->user->firstName);

        $this->assertSame('ru', $messageEntity->language);
        $this->assertSame('x6', $messageEntity->customEmojiId);
    }
}

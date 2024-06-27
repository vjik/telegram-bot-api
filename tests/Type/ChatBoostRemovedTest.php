<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\Chat;
use Vjik\TelegramBot\Api\Type\ChatBoostRemoved;
use Vjik\TelegramBot\Api\Type\ChatBoostSourcePremium;
use Vjik\TelegramBot\Api\Type\User;

final class ChatBoostRemovedTest extends TestCase
{
    public function testBase(): void
    {
        $chat = new Chat(1, 'private');
        $removeDate = new DateTimeImmutable();
        $source = new ChatBoostSourcePremium(new User(1, false, 'Sergei'));
        $chatBoostRemoved = new ChatBoostRemoved($chat, 'b1', $removeDate, $source);

        $this->assertSame($chat, $chatBoostRemoved->chat);
        $this->assertSame('b1', $chatBoostRemoved->boostId);
        $this->assertSame($removeDate, $chatBoostRemoved->removeDate);
        $this->assertSame($source, $chatBoostRemoved->source);
    }

    public function testFromTelegramResult(): void
    {
        $chatBoostRemoved = ChatBoostRemoved::fromTelegramResult([
            'chat' => [
                'id' => 1,
                'type' => 'private',
            ],
            'boost_id' => 'b1',
            'remove_date' => 1619040000,
            'source' => [
                'source' => 'premium',
                'user' => [
                    'id' => 1,
                    'is_bot' => false,
                    'first_name' => 'Sergei',
                ],
            ],
        ]);

        $this->assertSame(1, $chatBoostRemoved->chat->id);
        $this->assertSame('private', $chatBoostRemoved->chat->type);

        $this->assertSame('b1', $chatBoostRemoved->boostId);
        $this->assertEquals(new DateTimeImmutable('@1619040000'), $chatBoostRemoved->removeDate);

        $this->assertInstanceOf(ChatBoostSourcePremium::class, $chatBoostRemoved->source);
        $this->assertSame(1, $chatBoostRemoved->source->user->id);
        $this->assertFalse($chatBoostRemoved->source->user->isBot);
        $this->assertSame('Sergei', $chatBoostRemoved->source->user->firstName);
    }
}

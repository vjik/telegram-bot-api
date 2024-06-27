<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\CallbackQuery;
use Vjik\TelegramBot\Api\Type\Message;
use Vjik\TelegramBot\Api\Type\User;

final class CallbackQueryTest extends TestCase
{
    public function testBase(): void
    {
        $user = new User(1, false, 'first_name');
        $callbackQuery = new CallbackQuery(
            'id1',
            $user,
            'cid1',
        );

        $this->assertSame('id1', $callbackQuery->id);
        $this->assertSame($user, $callbackQuery->from);
        $this->assertSame('cid1', $callbackQuery->chatInstance);
        $this->assertNull($callbackQuery->message);
        $this->assertNull($callbackQuery->inlineMessageId);
        $this->assertNull($callbackQuery->data);
        $this->assertNull($callbackQuery->gameShortName);
    }

    public function testFromTelegramResult(): void
    {
        $callbackQuery = CallbackQuery::fromTelegramResult([
            'id' => 'id1',
            'from' => [
                'id' => 1,
                'is_bot' => false,
                'first_name' => 'first_name',
            ],
            'chat_instance' => 'cid1',
            'message' => [
                'message_id' => 99,
                'text' => 'hello',
                'date' => 1717328141,
                'chat' => [
                    'id' => 23,
                    'type' => 'private',
                ],
            ],
            'inline_message_id' => 'm12',
            'data' => 'data1',
            'game_short_name' => 'game1',
        ]);

        $this->assertSame('id1', $callbackQuery->id);
        $this->assertSame(1, $callbackQuery->from->id);
        $this->assertSame('cid1', $callbackQuery->chatInstance);

        $this->assertInstanceOf(Message::class, $callbackQuery->message);
        $this->assertSame(99, $callbackQuery->message->messageId);
        $this->assertSame('hello', $callbackQuery->message->text);

        $this->assertSame('m12', $callbackQuery->inlineMessageId);
        $this->assertSame('data1', $callbackQuery->data);
        $this->assertSame('game1', $callbackQuery->gameShortName);
    }
}

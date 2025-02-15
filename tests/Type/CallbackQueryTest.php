<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\CallbackQuery;
use Vjik\TelegramBot\Api\Type\Message;
use Vjik\TelegramBot\Api\Type\User;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

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

        assertSame('id1', $callbackQuery->id);
        assertSame($user, $callbackQuery->from);
        assertSame('cid1', $callbackQuery->chatInstance);
        assertNull($callbackQuery->message);
        assertNull($callbackQuery->inlineMessageId);
        assertNull($callbackQuery->data);
        assertNull($callbackQuery->gameShortName);
    }

    public function testFromTelegramResult(): void
    {
        $callbackQuery = (new ObjectFactory())->create([
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
        ], null, CallbackQuery::class);

        assertSame('id1', $callbackQuery->id);
        assertSame(1, $callbackQuery->from->id);
        assertSame('cid1', $callbackQuery->chatInstance);

        assertInstanceOf(Message::class, $callbackQuery->message);
        assertSame(99, $callbackQuery->message->messageId);
        assertSame('hello', $callbackQuery->message->text);

        assertSame('m12', $callbackQuery->inlineMessageId);
        assertSame('data1', $callbackQuery->data);
        assertSame('game1', $callbackQuery->gameShortName);
    }
}

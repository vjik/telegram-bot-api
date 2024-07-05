<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\BusinessMessagesDeleted;
use Vjik\TelegramBot\Api\Type\Chat;

final class BusinessMessagesDeletedTest extends TestCase
{
    public function testBase(): void
    {
        $chat = new Chat(97, 'private');
        $businessMessagesDeleted = new BusinessMessagesDeleted(
            'cid1',
            $chat,
            [1, 2, 3],
        );

        $this->assertSame('cid1', $businessMessagesDeleted->businessConnectionId);
        $this->assertSame($chat, $businessMessagesDeleted->chat);
        $this->assertSame([1, 2, 3], $businessMessagesDeleted->messageIds);
    }

    public function testFromTelegramResult(): void
    {
        $businessMessagesDeleted = (new ObjectFactory())->create([
            'business_connection_id' => 'cid1',
            'chat' => [
                'id' => 97,
                'type' => 'private',
            ],
            'message_ids' => [1, 2, 3],
        ], null, BusinessMessagesDeleted::class);

        $this->assertSame('cid1', $businessMessagesDeleted->businessConnectionId);
        $this->assertSame(97, $businessMessagesDeleted->chat->id);
        $this->assertSame([1, 2, 3], $businessMessagesDeleted->messageIds);
    }
}

<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\ChatShared;

final class ChatSharedTest extends TestCase
{
    public function testBase(): void
    {
        $chatShared = new ChatShared(12, 89);

        $this->assertSame(12, $chatShared->requestId);
        $this->assertSame(89, $chatShared->chatId);
        $this->assertNull($chatShared->title);
        $this->assertNull($chatShared->username);
        $this->assertNull($chatShared->photo);
    }

    public function testFromTelegramResult(): void
    {
        $chatShared = ChatShared::fromTelegramResult([
            'request_id' => 12,
            'chat_id' => 89,
            'title' => 'Title',
            'username' => 'Vjik',
            'photo' => [
                ['file_id' => 'file_id1', 'file_unique_id' => 'file_unique_id1', 'width' => 1, 'height' => 2],
                ['file_id' => 'file_id2', 'file_unique_id' => 'file_unique_id2', 'width' => 3, 'height' => 4],
            ],
        ]);

        $this->assertSame(12, $chatShared->requestId);
        $this->assertSame(89, $chatShared->chatId);
        $this->assertSame('Title', $chatShared->title);
        $this->assertSame('Vjik', $chatShared->username);

        $this->assertCount(2, $chatShared->photo);
        $this->assertSame('file_id1', $chatShared->photo[0]->fileId);
        $this->assertSame('file_id2', $chatShared->photo[1]->fileId);
    }
}

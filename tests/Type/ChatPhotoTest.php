<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\ChatPhoto;

final class ChatPhotoTest extends TestCase
{
    public function testBase(): void
    {
        $chatPhoto = new ChatPhoto('a', 'b', 'c', 'd');

        $this->assertSame('a', $chatPhoto->smallFileId);
        $this->assertSame('b', $chatPhoto->smallFileUniqueId);
        $this->assertSame('c', $chatPhoto->bigFileId);
        $this->assertSame('d', $chatPhoto->bigFileUniqueId);
    }

    public function testFromTelegramResult(): void
    {
        $chatPhoto = (new ObjectFactory())->create([
            'small_file_id' => 'a',
            'small_file_unique_id' => 'b',
            'big_file_id' => 'c',
            'big_file_unique_id' => 'd',
        ], null, ChatPhoto::class);

        $this->assertSame('a', $chatPhoto->smallFileId);
        $this->assertSame('b', $chatPhoto->smallFileUniqueId);
        $this->assertSame('c', $chatPhoto->bigFileId);
        $this->assertSame('d', $chatPhoto->bigFileUniqueId);
    }
}

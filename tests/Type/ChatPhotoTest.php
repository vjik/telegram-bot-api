<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\ChatPhoto;

use function PHPUnit\Framework\assertSame;

final class ChatPhotoTest extends TestCase
{
    public function testBase(): void
    {
        $chatPhoto = new ChatPhoto('a', 'b', 'c', 'd');

        assertSame('a', $chatPhoto->smallFileId);
        assertSame('b', $chatPhoto->smallFileUniqueId);
        assertSame('c', $chatPhoto->bigFileId);
        assertSame('d', $chatPhoto->bigFileUniqueId);
    }

    public function testFromTelegramResult(): void
    {
        $chatPhoto = (new ObjectFactory())->create([
            'small_file_id' => 'a',
            'small_file_unique_id' => 'b',
            'big_file_id' => 'c',
            'big_file_unique_id' => 'd',
        ], null, ChatPhoto::class);

        assertSame('a', $chatPhoto->smallFileId);
        assertSame('b', $chatPhoto->smallFileUniqueId);
        assertSame('c', $chatPhoto->bigFileId);
        assertSame('d', $chatPhoto->bigFileUniqueId);
    }
}

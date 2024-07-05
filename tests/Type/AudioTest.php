<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\Audio;
use Vjik\TelegramBot\Api\Type\PhotoSize;

final class AudioTest extends TestCase
{
    public function testAudio(): void
    {
        $audio = new Audio(
            'id12',
            'full12',
            123,
        );

        $this->assertSame('id12', $audio->fileId);
        $this->assertSame('full12', $audio->fileUniqueId);
        $this->assertSame(123, $audio->duration);
        $this->assertNull($audio->performer);
        $this->assertNull($audio->title);
        $this->assertNull($audio->fileName);
        $this->assertNull($audio->mimeType);
        $this->assertNull($audio->fileSize);
        $this->assertNull($audio->thumbnail);
    }

    public function testFromTelegramResult(): void
    {
        $audio = (new ObjectFactory())->create([
            'file_id' => 'id12',
            'file_unique_id' => 'full12',
            'duration' => 123,
            'performer' => 'performer12',
            'title' => 'Hello',
            'file_name' => 'hello.mp3',
            'mime_type' => 'audio/mpeg',
            'file_size' => 12345,
            'thumbnail' => [
                'file_id' => 'id34',
                'file_unique_id' => 'full34',
                'width' => 320,
                'height' => 240,
            ],
        ], null, Audio::class);

        $this->assertSame('id12', $audio->fileId);
        $this->assertSame('full12', $audio->fileUniqueId);
        $this->assertSame(123, $audio->duration);
        $this->assertSame('performer12', $audio->performer);
        $this->assertSame('Hello', $audio->title);
        $this->assertSame('hello.mp3', $audio->fileName);
        $this->assertSame('audio/mpeg', $audio->mimeType);
        $this->assertSame(12345, $audio->fileSize);

        $this->assertInstanceOf(PhotoSize::class, $audio->thumbnail);
        $this->assertSame('id34', $audio->thumbnail->fileId);
    }
}

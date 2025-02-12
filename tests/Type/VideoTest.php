<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\Video;

final class VideoTest extends TestCase
{
    public function testBase(): void
    {
        $video = new Video('f12', 'fu12', 100, 200, 23);

        $this->assertSame('f12', $video->fileId);
        $this->assertSame('fu12', $video->fileUniqueId);
        $this->assertSame(100, $video->width);
        $this->assertSame(200, $video->height);
        $this->assertSame(23, $video->duration);
        $this->assertNull($video->thumbnail);
        $this->assertNull($video->fileName);
        $this->assertNull($video->mimeType);
        $this->assertNull($video->fileSize);
        $this->assertNull($video->cover);
        $this->assertNull($video->startTimestamp);
    }

    public function testFromTelegramResult(): void
    {
        $video = (new ObjectFactory())->create([
            'file_id' => 'f12',
            'file_unique_id' => 'fu12',
            'width' => 100,
            'height' => 200,
            'duration' => 23,
            'thumbnail' => [
                'file_id' => 'file_id-124',
                'file_unique_id' => 'file_unique_id',
                'width' => 500,
                'height' => 600,
            ],
            'cover' => [
                [
                    'file_id' => 'file_id-3',
                    'file_unique_id' => 'file_unique_id',
                    'width' => 150,
                    'height' => 150,
                ],
                [
                    'file_id' => 'file_id-4',
                    'file_unique_id' => 'file_unique_id',
                    'width' => 150,
                    'height' => 150,
                ],
            ],
            'start_timestamp' => 17,
            'file_name' => 'face.png',
            'mime_type' => 'image/png',
            'file_size' => 123,
        ], null, Video::class);

        $this->assertSame('f12', $video->fileId);
        $this->assertSame('fu12', $video->fileUniqueId);
        $this->assertSame(100, $video->width);
        $this->assertSame(200, $video->height);
        $this->assertSame(23, $video->duration);
        $this->assertSame('file_id-124', $video->thumbnail?->fileId);
        $this->assertSame('face.png', $video->fileName);
        $this->assertSame('image/png', $video->mimeType);
        $this->assertSame(123, $video->fileSize);
        $this->assertCount(2, $video->cover);
        $this->assertSame('file_id-3', $video->cover[0]->fileId);
        $this->assertSame('file_id-4', $video->cover[1]->fileId);
        $this->assertSame(17, $video->startTimestamp);
    }
}

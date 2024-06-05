<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
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
    }

    public function testFromTelegramResult(): void
    {
        $video = Video::fromTelegramResult([
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
            'file_name' => 'face.png',
            'mime_type' => 'image/png',
            'file_size' => 123,
        ]);

        $this->assertSame('f12', $video->fileId);
        $this->assertSame('fu12', $video->fileUniqueId);
        $this->assertSame(100, $video->width);
        $this->assertSame(200, $video->height);
        $this->assertSame(23, $video->duration);
        $this->assertSame('file_id-124', $video->thumbnail?->fileId);
        $this->assertSame('face.png', $video->fileName);
        $this->assertSame('image/png', $video->mimeType);
        $this->assertSame(123, $video->fileSize);
    }
}

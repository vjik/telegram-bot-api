<?php

declare(strict_types=1);

namespace Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\PaidMediaVideo;
use Vjik\TelegramBot\Api\Type\Video;

final class PaidMediaVideoTest extends TestCase
{
    public function testBase(): void
    {
        $video = new Video('fileId', 'fileUniqueId', 100, 200, 12);
        $type = new PaidMediaVideo($video);

        $this->assertSame('video', $type->getType());
        $this->assertSame($video, $type->video);
    }

    public function testFromTelegramResult(): void
    {
        $type = PaidMediaVideo::fromTelegramResult([
            'type' => 'video',
            'video' => [
                'file_id' => 'f12',
                'file_unique_id' => 'fu12',
                'width' => 100,
                'height' => 200,
                'duration' => 23,
            ],
        ]);

        $this->assertSame('video', $type->getType());
        $this->assertSame('f12', $type->video->fileId);
        $this->assertSame('fu12', $type->video->fileUniqueId);
        $this->assertSame(100, $type->video->width);
        $this->assertSame(200, $type->video->height);
        $this->assertSame(23, $type->video->duration);
    }
}

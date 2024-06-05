<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\Animation;
use Vjik\TelegramBot\Api\Type\PhotoSize;

final class AnimationTest extends TestCase
{
    public function testBase(): void
    {
        $animation = new Animation('fileId', 'fileUniqueId', 100, 200, 48);

        $this->assertSame('fileId', $animation->fileId);
        $this->assertSame('fileUniqueId', $animation->fileUniqueId);
        $this->assertSame(100, $animation->width);
        $this->assertSame(200, $animation->height);
        $this->assertSame(48, $animation->duration);
        $this->assertNull($animation->thumbnail);
        $this->assertNull($animation->fileName);
        $this->assertNull($animation->mimeType);
        $this->assertNull($animation->fileSize);
    }

    public function testFromTelegramResult(): void
    {
        $animation = Animation::fromTelegramResult([
            'file_id' => 'fileId',
            'file_unique_id' => 'fileUniqueId',
            'width' => 100,
            'height' => 200,
            'duration' => 48,
            'thumbnail' => [
                'file_id' => 'thumbFileId',
                'file_unique_id' => 'thumbFileUniqueId',
                'width' => 50,
                'height' => 72,
            ],
            'file_name' => 'face.gif',
            'mime_type' => 'image/gif',
            'file_size' => 512,
        ]);

        $this->assertInstanceOf(Animation::class, $animation);
        $this->assertSame('fileId', $animation->fileId);
        $this->assertSame('fileUniqueId', $animation->fileUniqueId);
        $this->assertSame(100, $animation->width);
        $this->assertSame(200, $animation->height);
        $this->assertSame(48, $animation->duration);
        $this->assertEquals(new PhotoSize('thumbFileId', 'thumbFileUniqueId', 50, 72), $animation->thumbnail);
        $this->assertSame('face.gif', $animation->fileName);
        $this->assertSame('image/gif', $animation->mimeType);
        $this->assertSame(512, $animation->fileSize);
    }
}

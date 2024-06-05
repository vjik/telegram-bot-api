<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\PhotoSize;

final class PhotoSizeTest extends TestCase
{
    public function testBase(): void
    {
        $photoSize = new PhotoSize('fileId', 'fileUniqueId', 100, 200);

        $this->assertSame('fileId', $photoSize->fileId);
        $this->assertSame('fileUniqueId', $photoSize->fileUniqueId);
        $this->assertSame(100, $photoSize->width);
        $this->assertSame(200, $photoSize->height);
        $this->assertSame(null, $photoSize->fileSize);
    }

    public function testFromTelegramResult(): void
    {
        $photoSize = PhotoSize::fromTelegramResult([
            'file_id' => 'fileId',
            'file_unique_id' => 'fileUniqueId',
            'width' => 100,
            'height' => 200,
            'file_size' => 512,
        ]);

        $this->assertInstanceOf(PhotoSize::class, $photoSize);
        $this->assertSame('fileId', $photoSize->fileId);
        $this->assertSame('fileUniqueId', $photoSize->fileUniqueId);
        $this->assertSame(100, $photoSize->width);
        $this->assertSame(200, $photoSize->height);
        $this->assertSame(512, $photoSize->fileSize);
    }
}

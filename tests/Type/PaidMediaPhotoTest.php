<?php

declare(strict_types=1);

namespace Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\PaidMediaPhoto;
use Vjik\TelegramBot\Api\Type\PhotoSize;

final class PaidMediaPhotoTest extends TestCase
{
    public function testBase(): void
    {
        $photoSize = new PhotoSize('fileId', 'fileUniqueId', 100, 200);
        $type = new PaidMediaPhoto([$photoSize]);

        $this->assertSame('photo', $type->getType());
        $this->assertSame([$photoSize], $type->photo);
    }

    public function testFromTelegramResult(): void
    {
        $type = PaidMediaPhoto::fromTelegramResult([
            'type' => 'photo',
            'photo' => [
                [
                    'file_id' => 'fileId',
                    'file_unique_id' => 'fileUniqueId',
                    'width' => 100,
                    'height' => 200,
                    'file_size' => 512,
                ],
            ]
        ]);

        $this->assertSame('photo', $type->getType());
        $this->assertCount(1, $type->photo);
        $this->assertInstanceOf(PhotoSize::class, $type->photo[0]);
        $this->assertSame('fileId', $type->photo[0]->fileId);
        $this->assertSame('fileUniqueId', $type->photo[0]->fileUniqueId);
        $this->assertSame(100, $type->photo[0]->width);
        $this->assertSame(200, $type->photo[0]->height);
        $this->assertSame(512, $type->photo[0]->fileSize);
    }
}

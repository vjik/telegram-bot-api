<?php

declare(strict_types=1);

namespace Type\Sticker;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\File;
use Vjik\TelegramBot\Api\Type\PhotoSize;
use Vjik\TelegramBot\Api\Type\Sticker\MaskPosition;
use Vjik\TelegramBot\Api\Type\Sticker\Sticker;

final class StickerTest extends TestCase
{
    public function testSticker(): void
    {
        $sticker = new Sticker(
            'x1',
            'fullX1',
            'regular',
            100,
            120,
            false,
            true,
        );

        $this->assertSame('x1', $sticker->fileId);
        $this->assertSame('fullX1', $sticker->fileUniqueId);
        $this->assertSame('regular', $sticker->type);
        $this->assertSame(100, $sticker->width);
        $this->assertSame(120, $sticker->height);
        $this->assertFalse($sticker->isAnimated);
        $this->assertTrue($sticker->isVideo);
        $this->assertNull($sticker->thumbnail);
        $this->assertNull($sticker->emoji);
        $this->assertNull($sticker->setName);
        $this->assertNull($sticker->premiumAnimation);
        $this->assertNull($sticker->maskPosition);
        $this->assertNull($sticker->customEmojiId);
        $this->assertNull($sticker->needsRepainting);
        $this->assertNull($sticker->fileSize);
    }

    public function testFromTelegramResult(): void
    {
        $sticker = Sticker::fromTelegramResult([
            'file_id' => 'x1',
            'file_unique_id' => 'fullX1',
            'type' => 'regular',
            'width' => 100,
            'height' => 120,
            'is_animated' => false,
            'is_video' => true,
            'thumbnail' => [
                'file_id' => 'x2',
                'file_unique_id' => 'fullX2',
                'width' => 200,
                'height' => 240,
            ],
            'emoji' => '😀',
            'set_name' => 'hello-name',
            'premium_animation' => [
                'file_id' => 'x3',
                'file_unique_id' => 'fullX3',
                'width' => 300,
                'height' => 360,
            ],
            'mask_position' => [
                'point' => 'forehead',
                'x_shift' => 1.1,
                'y_shift' => 2.2,
                'scale' => 3.3,
            ],
            'custom_emoji_id' => 'customEmojiId',
            'needs_repainting' => true,
            'file_size' => 123,
        ]);

        $this->assertSame('x1', $sticker->fileId);
        $this->assertSame('fullX1', $sticker->fileUniqueId);
        $this->assertSame('regular', $sticker->type);
        $this->assertSame(100, $sticker->width);
        $this->assertSame(120, $sticker->height);
        $this->assertFalse($sticker->isAnimated);
        $this->assertTrue($sticker->isVideo);

        $this->assertInstanceOf(PhotoSize::class, $sticker->thumbnail);
        $this->assertSame('x2', $sticker->thumbnail->fileId);

        $this->assertSame('😀', $sticker->emoji);
        $this->assertSame('hello-name', $sticker->setName);

        $this->assertInstanceOf(File::class, $sticker->premiumAnimation);
        $this->assertSame('x3', $sticker->premiumAnimation->fileId);

        $this->assertInstanceOf(MaskPosition::class, $sticker->maskPosition);
        $this->assertSame('forehead', $sticker->maskPosition->point);

        $this->assertSame('customEmojiId', $sticker->customEmojiId);
        $this->assertTrue($sticker->needsRepainting);
        $this->assertSame(123, $sticker->fileSize);
    }
}

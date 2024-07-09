<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Sticker;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\Sticker\StickerSet;

final class StickerSetTest extends TestCase
{
    public function testBase(): void
    {
        $set = new StickerSet('test_by_bot', 'test', 'regular', []);

        $this->assertSame('test_by_bot', $set->name);
        $this->assertSame('test', $set->title);
        $this->assertSame('regular', $set->stickerType);
        $this->assertSame([], $set->stickers);
    }

    public function testFromTelegramResult(): void
    {
        $set = (new ObjectFactory())->create([
            'name' => 'test_by_bot',
            'title' => 'test',
            'sticker_type' => 'regular',
            'stickers' => [
                [
                    'file_id' => 'fid1',
                    'file_unique_id' => 'fuid1',
                    'type' => 'regular',
                    'width' => 200,
                    'height' => 300,
                    'is_animated' => false,
                    'is_video' => false,
                ],
            ],
            'thumbnail' => [
                'file_id' => 'tf1',
                'file_unique_id' => 'tfu1',
                'width' => 1,
                'height' => 2,
            ],
        ], null, StickerSet::class);

        $this->assertSame('test_by_bot', $set->name);
        $this->assertSame('test', $set->title);
        $this->assertSame('regular', $set->stickerType);
        $this->assertCount(1, $set->stickers);
        $this->assertSame('fid1', $set->stickers[0]->fileId);
        $this->assertSame('tf1', $set->thumbnail->fileId);
    }
}

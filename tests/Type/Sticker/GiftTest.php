<?php

declare(strict_types=1);

namespace Type\Sticker;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\Sticker\Gift;
use Vjik\TelegramBot\Api\Type\Sticker\Sticker;

final class GiftTest extends TestCase
{
    public function testBase(): void
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
        $object = new Gift(
            'test-id',
            $sticker,
            12,
        );

        $this->assertSame('test-id', $object->id);
        $this->assertSame($sticker, $object->sticker);
        $this->assertSame(12, $object->starCount);
        $this->assertNull($object->totalCount);
        $this->assertNull($object->remainingCount);
    }

    public function testFromTelegramResult(): void
    {
        $object = (new ObjectFactory())->create([
            'id' => 'test-id',
            'sticker' => [
                'file_id' => 'x1',
                'file_unique_id' => 'fullX1',
                'type' => 'regular',
                'width' => 100,
                'height' => 120,
                'is_animated' => false,
                'is_video' => true,
            ],
            'star_count' => 11,
            'total_count' => 200,
            'remaining_count' => 30,
        ], null, Gift::class);

        $this->assertSame('test-id', $object->id);
        $this->assertSame('x1', $object->sticker->fileId);
        $this->assertSame(11, $object->starCount);
        $this->assertSame(200, $object->totalCount);
        $this->assertSame(30, $object->remainingCount);
    }
}

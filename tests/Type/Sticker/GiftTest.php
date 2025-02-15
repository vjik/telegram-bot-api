<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Sticker;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\Sticker\Gift;
use Vjik\TelegramBot\Api\Type\Sticker\Sticker;

use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

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

        assertSame('test-id', $object->id);
        assertSame($sticker, $object->sticker);
        assertSame(12, $object->starCount);
        assertNull($object->totalCount);
        assertNull($object->remainingCount);
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
            'upgrade_star_count' => 53,
            'total_count' => 200,
            'remaining_count' => 30,
        ], null, Gift::class);

        assertSame('test-id', $object->id);
        assertSame('x1', $object->sticker->fileId);
        assertSame(11, $object->starCount);
        assertSame(53, $object->upgradeStarCount);
        assertSame(200, $object->totalCount);
        assertSame(30, $object->remainingCount);
    }
}

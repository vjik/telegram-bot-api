<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\PaidMediaInfo;
use Vjik\TelegramBot\Api\Type\PaidMediaPhoto;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertSame;

final class PaidMediaInfoTest extends TestCase
{
    public function testBase(): void
    {
        $photo = new PaidMediaPhoto([]);
        $type = new PaidMediaInfo(1, [$photo]);

        assertSame(1, $type->starCount);
        assertSame([$photo], $type->paidMedia);
    }

    public function testFromTelegramResult(): void
    {
        $type = (new ObjectFactory())->create([
            'star_count' => 1,
            'paid_media' => [
                [
                    'type' => 'photo',
                    'photo' => [],
                ],
            ],
        ], null, PaidMediaInfo::class);

        assertSame(1, $type->starCount);
        assertEquals([new PaidMediaPhoto([])], $type->paidMedia);
    }
}

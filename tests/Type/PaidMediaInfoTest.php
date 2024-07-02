<?php

declare(strict_types=1);

namespace Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\PaidMediaInfo;
use Vjik\TelegramBot\Api\Type\PaidMediaPhoto;

final class PaidMediaInfoTest extends TestCase
{
    public function testBase(): void
    {
        $photo = new PaidMediaPhoto([]);
        $type = new PaidMediaInfo(1, [$photo]);

        $this->assertSame(1, $type->starCount);
        $this->assertSame([$photo], $type->paidMedia);
    }

    public function testFromTelegramResult(): void
    {
        $type = PaidMediaInfo::fromTelegramResult([
            'star_count' => 1,
            'paid_media' => [
                [
                    'type' => 'photo',
                    'photo' => [],
                ],
            ]
        ]);

        $this->assertSame(1, $type->starCount);
        $this->assertEquals([new PaidMediaPhoto([])], $type->paidMedia);
    }
}

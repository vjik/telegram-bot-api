<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\BusinessIntro;
use Vjik\TelegramBot\Api\Type\Sticker\Sticker;

final class BusinessIntroTest extends TestCase
{
    public function testBase(): void
    {
        $businessIntro = new BusinessIntro();

        $this->assertNull($businessIntro->title);
        $this->assertNull($businessIntro->message);
        $this->assertNull($businessIntro->sticker);
    }

    public function testFromTelegramResult(): void
    {
        $businessIntro = BusinessIntro::fromTelegramResult([
            'title' => 'title1',
            'message' => 'message1',
            'sticker' => [
                'file_id' => 'file_id1',
                'file_unique_id' => 'file_unique_id1',
                'type' => 'regular',
                'width' => 23,
                'height' => 42,
                'is_animated' => true,
                'is_video' => false,
            ],
        ]);

        $this->assertSame('title1', $businessIntro->title);
        $this->assertSame('message1', $businessIntro->message);

        $this->assertInstanceOf(Sticker::class, $businessIntro->sticker);
        $this->assertSame('file_id1', $businessIntro->sticker->fileId);
    }
}

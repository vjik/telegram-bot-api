<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Sticker;

use HttpSoft\Message\StreamFactory;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Constant\Sticker\StickerFormat;
use Vjik\TelegramBot\Api\InputFileCollector;
use Vjik\TelegramBot\Api\Type\InputFile;
use Vjik\TelegramBot\Api\Type\Sticker\InputSticker;
use Vjik\TelegramBot\Api\Type\Sticker\MaskPosition;

final class InputStickerTest extends TestCase
{
    public function testBase(): void
    {
        $inputSticker = new InputSticker(
            'https://example.com/emoji.png',
            'static',
            ['👍', '👎'],
        );

        $this->assertSame(
            [
                'sticker' => 'https://example.com/emoji.png',
                'format' => 'static',
                'emoji_list' => ['👍', '👎'],
            ],
            $inputSticker->toRequestArray(),
        );

        $fileCollector = new InputFileCollector();
        $this->assertSame(
            [
                'sticker' => 'https://example.com/emoji.png',
                'format' => 'static',
                'emoji_list' => ['👍', '👎'],
            ],
            $inputSticker->toRequestArray($fileCollector),
        );
        $this->assertEmpty($fileCollector->get());
    }

    public function testFull(): void
    {
        $file = new InputFile((new StreamFactory())->createStream());
        $maskPosition = new MaskPosition('forehead', 0.5, 0.6, 0.7);
        $inputSticker = new InputSticker(
            $file,
            StickerFormat::STATIC,
            ['👍', '👎'],
            $maskPosition,
            ['test'],
        );

        $this->assertSame(
            [
                'sticker' => $file,
                'format' => 'static',
                'emoji_list' => ['👍', '👎'],
                'mask_position' => $maskPosition->toRequestArray(),
                'keywords' => ['test'],
            ],
            $inputSticker->toRequestArray(),
        );

        $fileCollector = new InputFileCollector();
        $this->assertSame(
            [
                'sticker' => 'attach://file0',
                'format' => 'static',
                'emoji_list' => ['👍', '👎'],
                'mask_position' => $maskPosition->toRequestArray(),
                'keywords' => ['test'],
            ],
            $inputSticker->toRequestArray($fileCollector),
        );
        $this->assertSame(
            [
                'file0' => $file,
            ],
            $fileCollector->get(),
        );
    }
}

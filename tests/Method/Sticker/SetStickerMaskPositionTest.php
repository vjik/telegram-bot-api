<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method\Sticker;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\Sticker\SetStickerMaskPosition;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;
use Vjik\TelegramBot\Api\Type\Sticker\MaskPosition;

final class SetStickerMaskPositionTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SetStickerMaskPosition('sid');

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('setStickerMaskPosition', $method->getApiMethod());
        $this->assertSame(
            [
                'sticker' => 'sid',
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $maskPosition = new MaskPosition('forehead', 0.5, 0.5, 45);
        $method = new SetStickerMaskPosition('sid', $maskPosition);

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('setStickerMaskPosition', $method->getApiMethod());
        $this->assertSame(
            [
                'sticker' => 'sid',
                'mask_position' => $maskPosition->toRequestArray(),
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SetStickerMaskPosition('sid');

        $preparedResult = TestHelper::createSuccessStubApi(true)->send($method);

        $this->assertTrue($preparedResult);
    }
}

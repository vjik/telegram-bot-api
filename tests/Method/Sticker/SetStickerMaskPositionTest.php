<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method\Sticker;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\Sticker\SetStickerMaskPosition;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;
use Vjik\TelegramBot\Api\Type\Sticker\MaskPosition;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class SetStickerMaskPositionTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SetStickerMaskPosition('sid');

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('setStickerMaskPosition', $method->getApiMethod());
        assertSame(
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

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('setStickerMaskPosition', $method->getApiMethod());
        assertSame(
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

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}

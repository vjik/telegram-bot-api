<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method\Sticker;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\Sticker\SetStickerPositionInSet;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class SetStickerPositionInSetTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SetStickerPositionInSet('sid', 2);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('setStickerPositionInSet', $method->getApiMethod());
        assertSame(
            [
                'sticker' => 'sid',
                'position' => 2,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SetStickerPositionInSet('sid', 1);

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}

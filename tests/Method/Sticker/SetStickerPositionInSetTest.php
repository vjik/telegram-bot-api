<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method\Sticker;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\Sticker\SetStickerPositionInSet;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;

final class SetStickerPositionInSetTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SetStickerPositionInSet('sid', 2);

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('setStickerPositionInSet', $method->getApiMethod());
        $this->assertSame(
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

        $preparedResult = TestHelper::createSuccessStubApi(true)->send($method);

        $this->assertTrue($preparedResult);
    }
}

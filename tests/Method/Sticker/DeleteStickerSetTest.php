<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method\Sticker;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\Sticker\DeleteStickerSet;
use Vjik\TelegramBot\Api\Request\HttpMethod;

final class DeleteStickerSetTest extends TestCase
{
    public function testBase(): void
    {
        $method = new DeleteStickerSet('test_by_bot');

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('deleteStickerSet', $method->getApiMethod());
        $this->assertSame(
            [
                'name' => 'test_by_bot',
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new DeleteStickerSet('test_by_bot');

        $preparedResult = $method->prepareResult(true);

        $this->assertTrue($preparedResult);
    }
}

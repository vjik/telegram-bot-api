<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method\Sticker;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\Sticker\DeleteStickerFromSet;
use Vjik\TelegramBot\Api\Request\HttpMethod;

final class DeleteStickerFromSetTest extends TestCase
{
    public function testBase(): void
    {
        $method = new DeleteStickerFromSet('id');

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('deleteStickerFromSet', $method->getApiMethod());
        $this->assertSame(
            [
                'sticker' => 'id',
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new DeleteStickerFromSet('id');

        $preparedResult = $method->prepareResult(true);

        $this->assertTrue($preparedResult);
    }
}

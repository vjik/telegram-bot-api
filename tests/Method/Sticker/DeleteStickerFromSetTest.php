<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method\Sticker;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\Sticker\DeleteStickerFromSet;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;

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

        $preparedResult = TestHelper::createSuccessStubApi(true)->send($method);

        $this->assertTrue($preparedResult);
    }
}

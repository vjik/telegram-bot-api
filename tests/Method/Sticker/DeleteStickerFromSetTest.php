<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method\Sticker;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\Sticker\DeleteStickerFromSet;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class DeleteStickerFromSetTest extends TestCase
{
    public function testBase(): void
    {
        $method = new DeleteStickerFromSet('id');

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('deleteStickerFromSet', $method->getApiMethod());
        assertSame(
            [
                'sticker' => 'id',
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new DeleteStickerFromSet('id');

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}

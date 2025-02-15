<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method\Sticker;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\Sticker\SetStickerKeywords;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class SetStickerKeywordsTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SetStickerKeywords('sid');

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('setStickerKeywords', $method->getApiMethod());
        assertSame(
            [
                'sticker' => 'sid',
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $method = new SetStickerKeywords('sid', ['hello', 'world']);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('setStickerKeywords', $method->getApiMethod());
        assertSame(
            [
                'sticker' => 'sid',
                'keywords' => ['hello', 'world'],
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SetStickerKeywords('sid');

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}

<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method\Sticker;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\Sticker\SetStickerKeywords;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;

final class SetStickerKeywordsTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SetStickerKeywords('sid');

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('setStickerKeywords', $method->getApiMethod());
        $this->assertSame(
            [
                'sticker' => 'sid',
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $method = new SetStickerKeywords('sid', ['hello', 'world']);

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('setStickerKeywords', $method->getApiMethod());
        $this->assertSame(
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

        $this->assertTrue($preparedResult);
    }
}

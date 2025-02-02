<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method\Sticker;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\Sticker\SetStickerSetTitle;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;

final class SetStickerSetTitleTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SetStickerSetTitle('animals_by_bot', 'The Animal');

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('setStickerSetTitle', $method->getApiMethod());
        $this->assertSame(
            [
                'name' => 'animals_by_bot',
                'title' => 'The Animal',
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SetStickerSetTitle('animals_by_bot', 'The Animal');

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        $this->assertTrue($preparedResult);
    }
}

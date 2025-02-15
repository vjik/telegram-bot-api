<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method\Sticker;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\Sticker\SetStickerSetTitle;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class SetStickerSetTitleTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SetStickerSetTitle('animals_by_bot', 'The Animal');

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('setStickerSetTitle', $method->getApiMethod());
        assertSame(
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

        assertTrue($preparedResult);
    }
}

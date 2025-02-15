<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\SetChatStickerSet;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class SetChatStickerSetTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SetChatStickerSet(1, 'animals_by_bot');

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('setChatStickerSet', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 1,
                'sticker_set_name' => 'animals_by_bot',
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SetChatStickerSet(1, 'animals_by_bot');

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}

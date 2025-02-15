<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method\Sticker;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\Sticker\SetStickerEmojiList;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class SetStickerEmojiListTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SetStickerEmojiList('sid', ['👀']);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('setStickerEmojiList', $method->getApiMethod());
        assertSame(
            [
                'sticker' => 'sid',
                'emoji_list' => ['👀'],
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SetStickerEmojiList('sid', ['👀']);

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}

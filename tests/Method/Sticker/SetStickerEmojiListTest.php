<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method\Sticker;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\Sticker\SetStickerEmojiList;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;

final class SetStickerEmojiListTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SetStickerEmojiList('sid', ['👀']);

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('setStickerEmojiList', $method->getApiMethod());
        $this->assertSame(
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

        $preparedResult = TestHelper::createSuccessStubApi(true)->send($method);

        $this->assertTrue($preparedResult);
    }
}

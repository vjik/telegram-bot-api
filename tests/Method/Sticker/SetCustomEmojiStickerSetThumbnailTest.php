<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method\Sticker;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\Sticker\SetCustomEmojiStickerSetThumbnail;
use Vjik\TelegramBot\Api\Request\HttpMethod;

final class SetCustomEmojiStickerSetThumbnailTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SetCustomEmojiStickerSetThumbnail('animals_by_my_bot');

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('setCustomEmojiStickerSetThumbnail', $method->getApiMethod());
        $this->assertSame(
            [
                'name' => 'animals_by_my_bot',
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $method = new SetCustomEmojiStickerSetThumbnail('animals_by_my_bot', 'ceid');

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('setCustomEmojiStickerSetThumbnail', $method->getApiMethod());
        $this->assertSame(
            [
                'name' => 'animals_by_my_bot',
                'custom_emoji_id' => 'ceid',
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SetCustomEmojiStickerSetThumbnail('animals_by_my_bot');

        $preparedResult = $method->prepareResult(true);

        $this->assertTrue($preparedResult);
    }
}

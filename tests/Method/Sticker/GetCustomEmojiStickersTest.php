<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method\Sticker;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\Sticker\GetCustomEmojiStickers;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Type\Sticker\Sticker;

final class GetCustomEmojiStickersTest extends TestCase
{
    public function testBase(): void
    {
        $method = new GetCustomEmojiStickers(['id1']);

        $this->assertSame(HttpMethod::GET, $method->getHttpMethod());
        $this->assertSame('getCustomEmojiStickers', $method->getApiMethod());
        $this->assertSame(
            [
                'custom_emoji_ids' => ['id1'],
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new GetCustomEmojiStickers(['id1']);

        $preparedResult = $method->prepareResult([
            [
                'file_id' => 'x1',
                'file_unique_id' => 'fullX1',
                'type' => 'regular',
                'width' => 100,
                'height' => 120,
                'is_animated' => false,
                'is_video' => true,
            ],
        ]);

        $this->assertIsArray($preparedResult);
        $this->assertCount(1, $preparedResult);
        $this->assertInstanceOf(Sticker::class, $preparedResult[0]);
        $this->assertSame('x1', $preparedResult[0]->fileId);
    }
}

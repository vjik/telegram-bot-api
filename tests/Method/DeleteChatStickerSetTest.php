<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\DeleteChatStickerSet;
use Vjik\TelegramBot\Api\Request\HttpMethod;

final class DeleteChatStickerSetTest extends TestCase
{
    public function testBase(): void
    {
        $method = new DeleteChatStickerSet(1);

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('deleteChatStickerSet', $method->getApiMethod());
        $this->assertSame(
            [
                'chat_id' => 1,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new DeleteChatStickerSet(1);

        $preparedResult = $method->prepareResult(true);

        $this->assertTrue($preparedResult);
    }
}

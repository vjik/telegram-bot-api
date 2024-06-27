<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\DeleteChatPhoto;
use Vjik\TelegramBot\Api\Request\HttpMethod;

final class DeleteChatPhotoTest extends TestCase
{
    public function testBase(): void
    {
        $method = new DeleteChatPhoto(1);

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('deleteChatPhoto', $method->getApiMethod());
        $this->assertSame(
            [
                'chat_id' => 1,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new DeleteChatPhoto(1);

        $preparedResult = $method->prepareResult(true);

        $this->assertTrue($preparedResult);
    }
}

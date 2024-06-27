<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\PinChatMessage;
use Vjik\TelegramBot\Api\Request\HttpMethod;

final class PinChatMessageTest extends TestCase
{
    public function testBase(): void
    {
        $method = new PinChatMessage(1, 2);

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('pinChatMessage', $method->getApiMethod());
        $this->assertSame(
            [
                'chat_id' => 1,
                'message_id' => 2,
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $method = new PinChatMessage(1, 2, true);

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('pinChatMessage', $method->getApiMethod());
        $this->assertSame(
            [
                'chat_id' => 1,
                'message_id' => 2,
                'disable_notification' => true,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new PinChatMessage(1, 2);

        $preparedResult = $method->prepareResult(true);

        $this->assertTrue($preparedResult);
    }
}

<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\UnpinChatMessage;
use Vjik\TelegramBot\Api\Request\HttpMethod;

final class UnpinChatMessageTest extends TestCase
{
    public function testBase(): void
    {
        $method = new UnpinChatMessage(1);

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('unpinChatMessage', $method->getApiMethod());
        $this->assertSame(
            [
                'chat_id' => 1,
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $method = new UnpinChatMessage(1, 2);

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('unpinChatMessage', $method->getApiMethod());
        $this->assertSame(
            [
                'chat_id' => 1,
                'message_id' => 2,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new UnpinChatMessage(1, 2);

        $preparedResult = $method->prepareResult(true);

        $this->assertTrue($preparedResult);
    }
}

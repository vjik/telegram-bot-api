<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\UnpinAllChatMessages;
use Vjik\TelegramBot\Api\Request\HttpMethod;

final class UnpinAllChatMessagesTest extends TestCase
{
    public function testBase(): void
    {
        $method = new UnpinAllChatMessages(1);

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('unpinAllChatMessages', $method->getApiMethod());
        $this->assertSame(
            [
                'chat_id' => 1,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new UnpinAllChatMessages(1);

        $preparedResult = $method->prepareResult(true);

        $this->assertTrue($preparedResult);
    }
}

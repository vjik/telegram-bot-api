<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\UnbanChatSenderChat;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class UnbanChatSenderChatTest extends TestCase
{
    public function testBase(): void
    {
        $method = new UnbanChatSenderChat(1, 2);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('unbanChatSenderChat', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 1,
                'sender_chat_id' => 2,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new UnbanChatSenderChat(1, 2);

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}

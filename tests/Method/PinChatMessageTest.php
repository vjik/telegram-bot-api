<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\PinChatMessage;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class PinChatMessageTest extends TestCase
{
    public function testBase(): void
    {
        $method = new PinChatMessage(1, 2);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('pinChatMessage', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 1,
                'message_id' => 2,
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $method = new PinChatMessage(1, 2, true, 'bid');

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('pinChatMessage', $method->getApiMethod());
        assertSame(
            [
                'business_connection_id' => 'bid',
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

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}

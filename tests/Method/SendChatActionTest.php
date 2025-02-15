<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\SendChatAction;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class SendChatActionTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SendChatAction(12, 'typing');

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('sendChatAction', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 12,
                'action' => 'typing',
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $method = new SendChatAction(12, 'testing', 'bcid', 23);

        assertSame(
            [
                'business_connection_id' => 'bcid',
                'chat_id' => 12,
                'message_thread_id' => 23,
                'action' => 'testing',
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SendChatAction(12, 'testing');

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}

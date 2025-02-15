<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\UnpinAllChatMessages;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class UnpinAllChatMessagesTest extends TestCase
{
    public function testBase(): void
    {
        $method = new UnpinAllChatMessages(1);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('unpinAllChatMessages', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 1,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new UnpinAllChatMessages(1);

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}

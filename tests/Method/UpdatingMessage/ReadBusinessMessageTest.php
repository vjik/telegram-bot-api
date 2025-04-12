<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method\UpdatingMessage;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\UpdatingMessage\ReadBusinessMessage;

use Vjik\TelegramBot\Api\Tests\Support\TestHelper;
use Vjik\TelegramBot\Api\Transport\HttpMethod;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class ReadBusinessMessageTest extends TestCase
{
    public function testBase(): void
    {
        $method = new ReadBusinessMessage('connection1', 123, 456);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('readBusinessMessage', $method->getApiMethod());
        assertSame(
            [
                'business_connection_id' => 'connection1',
                'chat_id' => 123,
                'message_id' => 456,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new ReadBusinessMessage('connection1', 123, 456);

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}

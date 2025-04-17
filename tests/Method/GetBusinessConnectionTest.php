<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\GetBusinessConnection;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;

final class GetBusinessConnectionTest extends TestCase
{
    public function testBase(): void
    {
        $method = new GetBusinessConnection('b1');

        assertSame(HttpMethod::GET, $method->getHttpMethod());
        assertSame('getBusinessConnection', $method->getApiMethod());
        assertSame(['business_connection_id' => 'b1'], $method->getData());
    }

    public function testPrepareResult(): void
    {
        $method = new GetBusinessConnection('b1');

        $preparedResult = TestHelper::createSuccessStubApi([
            'id' => 'id1',
            'user' => [
                'id' => 123,
                'is_bot' => false,
                'first_name' => 'Sergei',
            ],
            'user_chat_id' => 23,
            'date' => 1717517779,
            'rights' => [],
            'is_enabled' => false,
        ])->call($method);

        assertSame('id1', $preparedResult->id);
    }
}

<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\SetBusinessAccountName;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;
use Vjik\TelegramBot\Api\Transport\HttpMethod;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class SetBusinessAccountNameTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SetBusinessAccountName('connection1', 'John');

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('setBusinessAccountName', $method->getApiMethod());
        assertSame(
            [
                'business_connection_id' => 'connection1',
                'first_name' => 'John',
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $method = new SetBusinessAccountName(
            'connection1',
            'John',
            'Doe',
        );

        assertSame(
            [
                'business_connection_id' => 'connection1',
                'first_name' => 'John',
                'last_name' => 'Doe',
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SetBusinessAccountName('connection1', 'John');

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}

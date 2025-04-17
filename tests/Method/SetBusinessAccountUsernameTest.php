<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\SetBusinessAccountUsername;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;
use Vjik\TelegramBot\Api\Transport\HttpMethod;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class SetBusinessAccountUsernameTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SetBusinessAccountUsername('connection1');

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('setBusinessAccountUsername', $method->getApiMethod());
        assertSame(
            ['business_connection_id' => 'connection1'],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $method = new SetBusinessAccountUsername('connection1', 'test_name');

        assertSame(
            [
                'business_connection_id' => 'connection1',
                'username' => 'test_name',
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SetBusinessAccountUsername('connection1');

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}

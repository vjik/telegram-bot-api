<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\VerifyUser;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class VerifyUserTest extends TestCase
{
    public function testBase(): void
    {
        $method = new VerifyUser(7);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('verifyUser', $method->getApiMethod());
        assertSame(
            [
                'user_id' => 7,
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $method = new VerifyUser(1, 'test');

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('verifyUser', $method->getApiMethod());
        assertSame(
            [
                'user_id' => 1,
                'custom_description' => 'test',
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new VerifyUser(5);

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}

<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\RemoveUserVerification;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class RemoveUserVerificationTest extends TestCase
{
    public function testBase(): void
    {
        $method = new RemoveUserVerification(7);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('removeUserVerification', $method->getApiMethod());
        assertSame(
            [
                'user_id' => 7,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new RemoveUserVerification(5);

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}

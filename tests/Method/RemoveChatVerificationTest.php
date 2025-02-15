<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\RemoveChatVerification;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class RemoveChatVerificationTest extends TestCase
{
    public function testBase(): void
    {
        $method = new RemoveChatVerification(7);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('removeChatVerification', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 7,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new RemoveChatVerification('id5');

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}

<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\RemoveChatVerification;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;

final class RemoveChatVerificationTest extends TestCase
{
    public function testBase(): void
    {
        $method = new RemoveChatVerification(7);

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('removeChatVerification', $method->getApiMethod());
        $this->assertSame(
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

        $this->assertTrue($preparedResult);
    }
}

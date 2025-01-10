<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\VerifyChat;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;

final class VerifyChatTest extends TestCase
{
    public function testBase(): void
    {
        $method = new VerifyChat(7);

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('verifyChat', $method->getApiMethod());
        $this->assertSame(
            [
                'chat_id' => 7,
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $method = new VerifyChat('id1', 'test');

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('verifyChat', $method->getApiMethod());
        $this->assertSame(
            [
                'chat_id' => 'id1',
                'custom_description' => 'test',
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new VerifyChat(5);

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        $this->assertTrue($preparedResult);
    }
}

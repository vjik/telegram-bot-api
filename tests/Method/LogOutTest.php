<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\LogOut;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;

final class LogOutTest extends TestCase
{
    public function testBase(): void
    {
        $method = new LogOut();

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('logOut', $method->getApiMethod());
        $this->assertSame([], $method->getData());
        $this->assertTrue(TestHelper::createSuccessStubApi(true)->send($method));
    }
}

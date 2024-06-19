<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\LogOut;
use Vjik\TelegramBot\Api\Request\HttpMethod;

final class LogOutTest extends TestCase
{
    public function testBase(): void
    {
        $method = new LogOut();

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('logOut', $method->getApiMethod());
        $this->assertSame([], $method->getData());
        $this->assertTrue($method->prepareResult(true));
    }
}

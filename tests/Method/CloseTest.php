<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\Close;
use Vjik\TelegramBot\Api\Request\HttpMethod;

final class CloseTest extends TestCase
{
    public function testBase(): void
    {
        $method = new Close();

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('close', $method->getApiMethod());
        $this->assertSame([], $method->getData());
        $this->assertTrue($method->prepareResult(true));
    }
}

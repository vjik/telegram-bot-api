<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\Close;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class CloseTest extends TestCase
{
    public function testBase(): void
    {
        $method = new Close();

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('close', $method->getApiMethod());
        assertSame([], $method->getData());
        assertTrue(TestHelper::createSuccessStubApi(true)->call($method));
    }
}

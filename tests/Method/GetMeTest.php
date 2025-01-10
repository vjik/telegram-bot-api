<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\GetMe;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;

final class GetMeTest extends TestCase
{
    public function testBase(): void
    {
        $method = new getMe();

        $this->assertSame(HttpMethod::GET, $method->getHttpMethod());
        $this->assertSame('getMe', $method->getApiMethod());
        $this->assertSame([], $method->getData());
    }

    public function testPrepareResult(): void
    {
        $method = new getMe();

        $preparedResult = TestHelper::createSuccessStubApi([
            'id' => 1,
            'is_bot' => false,
            'first_name' => 'Sergei',
        ])->send($method);

        $this->assertSame(1, $preparedResult->id);
    }
}

<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\GetMe;
use Vjik\TelegramBot\Api\Request\HttpMethod;

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

        $preparedResult = $method->prepareResult([
            'id' => 1,
            'is_bot' => false,
            'first_name' => 'Sergei',
        ]);

        $this->assertSame(1, $preparedResult->id);
    }
}

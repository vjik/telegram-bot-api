<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\SetMyName;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;

final class SetMyNameTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SetMyName();

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('setMyName', $method->getApiMethod());
        $this->assertSame([], $method->getData());
    }

    public function testFull(): void
    {
        $method = new SetMyName('test', 'ru');

        $this->assertSame(
            [
                'name' => 'test',
                'language_code' => 'ru',
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SetMyName();

        $preparedResult = TestHelper::createSuccessStubApi(true)->send($method);

        $this->assertTrue($preparedResult);
    }
}

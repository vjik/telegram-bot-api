<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\GetMyName;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;

final class GetMyNameTest extends TestCase
{
    public function testBase(): void
    {
        $method = new GetMyName();

        assertSame(HttpMethod::GET, $method->getHttpMethod());
        assertSame('getMyName', $method->getApiMethod());
        assertSame([], $method->getData());
    }

    public function testFull(): void
    {
        $method = new GetMyName('ru');

        assertSame(
            [
                'language_code' => 'ru',
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new GetMyName();

        $preparedResult = TestHelper::createSuccessStubApi([
            'name' => 'test',
        ])->call($method);

        assertSame('test', $preparedResult->name);
    }
}

<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\GetMyDescription;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;

final class GetMyDescriptionTest extends TestCase
{
    public function testBase(): void
    {
        $method = new GetMyDescription();

        assertSame(HttpMethod::GET, $method->getHttpMethod());
        assertSame('getMyDescription', $method->getApiMethod());
        assertSame([], $method->getData());
    }

    public function testFull(): void
    {
        $method = new GetMyDescription('ru');

        assertSame(
            [
                'language_code' => 'ru',
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new GetMyDescription();

        $preparedResult = TestHelper::createSuccessStubApi([
            'description' => 'test',
        ])->call($method);

        assertSame('test', $preparedResult->description);
    }
}

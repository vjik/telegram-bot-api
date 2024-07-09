<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\GetMyDescription;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;

final class GetMyDescriptionTest extends TestCase
{
    public function testBase(): void
    {
        $method = new GetMyDescription();

        $this->assertSame(HttpMethod::GET, $method->getHttpMethod());
        $this->assertSame('getMyDescription', $method->getApiMethod());
        $this->assertSame([], $method->getData());
    }

    public function testFull(): void
    {
        $method = new GetMyDescription('ru');

        $this->assertSame(
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
        ])->send($method);

        $this->assertSame('test', $preparedResult->description);
    }
}

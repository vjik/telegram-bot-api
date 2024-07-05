<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\GetMyShortDescription;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;

final class GetMyShortDescriptionTest extends TestCase
{
    public function testBase(): void
    {
        $method = new GetMyShortDescription();

        $this->assertSame(HttpMethod::GET, $method->getHttpMethod());
        $this->assertSame('getMyShortDescription', $method->getApiMethod());
        $this->assertSame([], $method->getData());
    }

    public function testFull(): void
    {
        $method = new GetMyShortDescription('ru');

        $this->assertSame(
            [
                'language_code' => 'ru',
            ],
            $method->getData()
        );
    }

    public function testPrepareResult(): void
    {
        $method = new GetMyShortDescription();

        $preparedResult = TestHelper::createSuccessStubApi([
            'short_description' => 'test',
        ])->send($method);

        $this->assertSame('test', $preparedResult->shortDescription);
    }
}

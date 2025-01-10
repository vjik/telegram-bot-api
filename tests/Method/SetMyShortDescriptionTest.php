<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\SetMyShortDescription;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;

final class SetMyShortDescriptionTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SetMyShortDescription();

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('setMyShortDescription', $method->getApiMethod());
        $this->assertSame([], $method->getData());
    }

    public function testFull(): void
    {
        $method = new SetMyShortDescription('test', 'ru');

        $this->assertSame(
            [
                'short_description' => 'test',
                'language_code' => 'ru',
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SetMyShortDescription();

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        $this->assertTrue($preparedResult);
    }
}

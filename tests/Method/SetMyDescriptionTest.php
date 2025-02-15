<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\SetMyDescription;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class SetMyDescriptionTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SetMyDescription();

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('setMyDescription', $method->getApiMethod());
        assertSame([], $method->getData());
    }

    public function testFull(): void
    {
        $method = new SetMyDescription('test', 'ru');

        assertSame(
            [
                'description' => 'test',
                'language_code' => 'ru',
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SetMyDescription();

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}

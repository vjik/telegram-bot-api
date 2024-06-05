<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\SetMyDescription;
use Vjik\TelegramBot\Api\Request\HttpMethod;

final class SetMyDescriptionTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SetMyDescription();

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('setMyDescription', $method->getApiMethod());
        $this->assertSame([], $method->getData());
    }

    public function testFull(): void
    {
        $method = new SetMyDescription('test', 'ru');

        $this->assertSame(
            [
                'description' => 'test',
                'language_code' => 'ru',
            ],
            $method->getData()
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SetMyDescription();

        $preparedResult = $method->prepareResult([]);

        $this->assertTrue($preparedResult);
    }
}

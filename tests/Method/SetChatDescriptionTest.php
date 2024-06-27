<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\SetChatDescription;
use Vjik\TelegramBot\Api\Request\HttpMethod;

final class SetChatDescriptionTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SetChatDescription(1);

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('setChatDescription', $method->getApiMethod());
        $this->assertSame(
            [
                'chat_id' => 1,
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $method = new SetChatDescription(1, 'test');

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('setChatDescription', $method->getApiMethod());
        $this->assertSame(
            [
                'chat_id' => 1,
                'description' => 'test',
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SetChatDescription(1);

        $preparedResult = $method->prepareResult(true);

        $this->assertTrue($preparedResult);
    }
}

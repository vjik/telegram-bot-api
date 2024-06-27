<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\SetChatTitle;
use Vjik\TelegramBot\Api\Request\HttpMethod;

final class SetChatTitleTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SetChatTitle(1, 'test');

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('setChatTitle', $method->getApiMethod());
        $this->assertSame(
            [
                'chat_id' => 1,
                'title' => 'test',
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SetChatTitle(1, 'test');

        $preparedResult = $method->prepareResult(true);

        $this->assertTrue($preparedResult);
    }
}

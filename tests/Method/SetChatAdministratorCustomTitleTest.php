<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\SetChatAdministratorCustomTitle;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;

final class SetChatAdministratorCustomTitleTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SetChatAdministratorCustomTitle(1,2,'test');

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('setChatAdministratorCustomTitle', $method->getApiMethod());
        $this->assertSame(
            [
                'chat_id' => 1,
                'user_id' => 2,
                'custom_title' => 'test',
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SetChatAdministratorCustomTitle(1,2,'test');

        $preparedResult = TestHelper::createSuccessStubApi(true)->send($method);

        $this->assertTrue($preparedResult);
    }
}

<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\GetChatMenuButton;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;
use Vjik\TelegramBot\Api\Type\MenuButtonDefault;

final class GetChatMenuButtonTest extends TestCase
{
    public function testBase(): void
    {
        $method = new GetChatMenuButton();

        $this->assertSame(HttpMethod::GET, $method->getHttpMethod());
        $this->assertSame('getChatMenuButton', $method->getApiMethod());
        $this->assertSame([], $method->getData());
    }

    public function testFull(): void
    {
        $method = new GetChatMenuButton(99);

        $this->assertSame(['chat_id' => 99], $method->getData());
    }

    public function testPrepareResult(): void
    {
        $method = new GetChatMenuButton();

        $preparedResult = TestHelper::createSuccessStubApi([
            'type' => 'default',
        ])->call($method);

        $this->assertInstanceOf(MenuButtonDefault::class, $preparedResult);
    }
}

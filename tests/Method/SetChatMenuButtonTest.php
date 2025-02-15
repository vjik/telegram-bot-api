<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\SetChatMenuButton;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;
use Vjik\TelegramBot\Api\Type\MenuButtonDefault;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class SetChatMenuButtonTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SetChatMenuButton();

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('setChatMenuButton', $method->getApiMethod());
        assertSame([], $method->getData());
    }

    public function testFull(): void
    {
        $menuButton = new MenuButtonDefault();
        $method = new SetChatMenuButton(99, $menuButton);

        assertSame(
            [
                'chat_id' => 99,
                'menu_button' => $menuButton->toRequestArray(),
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SetChatMenuButton();

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}

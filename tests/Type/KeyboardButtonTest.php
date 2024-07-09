<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\KeyboardButton;
use Vjik\TelegramBot\Api\Type\KeyboardButtonPollType;
use Vjik\TelegramBot\Api\Type\KeyboardButtonRequestChat;
use Vjik\TelegramBot\Api\Type\KeyboardButtonRequestUsers;
use Vjik\TelegramBot\Api\Type\WebAppInfo;

final class KeyboardButtonTest extends TestCase
{
    public function testBase(): void
    {
        $button = new KeyboardButton('test');

        $this->assertSame('test', $button->text);
        $this->assertNull($button->requestUsers);
        $this->assertNull($button->requestChat);
        $this->assertNull($button->requestContact);
        $this->assertNull($button->requestLocation);
        $this->assertNull($button->requestPoll);
        $this->assertNull($button->webApp);

        $this->assertSame(
            [
                'text' => 'test',
            ],
            $button->toRequestArray(),
        );
    }

    public function testFilled(): void
    {
        $requestUsers = new KeyboardButtonRequestUsers(1);
        $requestChat = new KeyboardButtonRequestChat(2, true);
        $requestPoll = new KeyboardButtonPollType('test');
        $webApp = new WebAppInfo('https://example.com/test');
        $button = new KeyboardButton(
            'test',
            $requestUsers,
            $requestChat,
            true,
            false,
            $requestPoll,
            $webApp,
        );

        $this->assertSame('test', $button->text);
        $this->assertSame($requestUsers, $button->requestUsers);
        $this->assertSame($requestChat, $button->requestChat);
        $this->assertTrue($button->requestContact);
        $this->assertFalse($button->requestLocation);
        $this->assertSame($requestPoll, $button->requestPoll);
        $this->assertSame($webApp, $button->webApp);

        $this->assertSame(
            [
                'text' => 'test',
                'request_users' => $requestUsers->toRequestArray(),
                'request_chat' => $requestChat->toRequestArray(),
                'request_contact' => true,
                'request_location' => false,
                'request_poll' => $requestPoll->toRequestArray(),
                'web_app' => $webApp->toRequestArray(),
            ],
            $button->toRequestArray(),
        );
    }
}

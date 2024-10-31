<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\CopyTextButton;
use Vjik\TelegramBot\Api\Type\Game\CallbackGame;
use Vjik\TelegramBot\Api\Type\InlineKeyboardButton;
use Vjik\TelegramBot\Api\Type\LoginUrl;
use Vjik\TelegramBot\Api\Type\SwitchInlineQueryChosenChat;
use Vjik\TelegramBot\Api\Type\WebAppInfo;

final class InlineKeyboardButtonTest extends TestCase
{
    public function testBase(): void
    {
        $button = new InlineKeyboardButton('test');

        $this->assertSame('test', $button->text);
        $this->assertNull($button->url);
        $this->assertNull($button->callbackData);
        $this->assertNull($button->webApp);
        $this->assertNull($button->loginUrl);
        $this->assertNull($button->switchInlineQuery);
        $this->assertNull($button->switchInlineQueryCurrentChat);
        $this->assertNull($button->switchInlineQueryChosenChat);
        $this->assertNull($button->copyText);
        $this->assertNull($button->callbackGame);
        $this->assertNull($button->pay);

        $this->assertSame(
            [
                'text' => 'test',
            ],
            $button->toRequestArray(),
        );
    }

    public function testFilled(): void
    {
        $webApp = new WebAppInfo('https://example.com/test');
        $loginUrl = new LoginUrl('https://example.com/login');
        $switchInlineQueryChosenChat  = new SwitchInlineQueryChosenChat('dg');
        $callbackGame = new CallbackGame();
        $copyText = new CopyTextButton('Copy it!');
        $button = new InlineKeyboardButton(
            'test',
            'https://example.com',
            'callback-data',
            $webApp,
            $loginUrl,
            'switch-inline-query',
            'switch-inline-query-current-chat',
            $switchInlineQueryChosenChat,
            $callbackGame,
            true,
            $copyText,
        );

        $this->assertSame('test', $button->text);
        $this->assertSame('https://example.com', $button->url);
        $this->assertSame('callback-data', $button->callbackData);
        $this->assertSame($webApp, $button->webApp);
        $this->assertSame($loginUrl, $button->loginUrl);
        $this->assertSame('switch-inline-query', $button->switchInlineQuery);
        $this->assertSame('switch-inline-query-current-chat', $button->switchInlineQueryCurrentChat);
        $this->assertSame($switchInlineQueryChosenChat, $button->switchInlineQueryChosenChat);
        $this->assertSame($copyText, $button->copyText);
        $this->assertSame($callbackGame, $button->callbackGame);
        $this->assertTrue($button->pay);

        $this->assertSame(
            [
                'text' => 'test',
                'url' => 'https://example.com',
                'callback_data' => 'callback-data',
                'web_app' => $webApp->toRequestArray(),
                'login_url' => $loginUrl->toRequestArray(),
                'switch_inline_query' => 'switch-inline-query',
                'switch_inline_query_current_chat' => 'switch-inline-query-current-chat',
                'switch_inline_query_chosen_chat' => $switchInlineQueryChosenChat->toRequestArray(),
                'copy_text' => $copyText->toRequestArray(),
                'callback_game' => $callbackGame->toRequestArray(),
                'pay' => true,
            ],
            $button->toRequestArray(),
        );
    }

    public function testFromTelegramResult(): void
    {
        $button = (new ObjectFactory())->create([
            'text' => 'test',
            'url' => 'https://example.com',
            'callback_data' => 'callback-data',
            'web_app' => ['url' => 'https://example.com/test'],
            'login_url' => ['url' => 'https://example.com/login'],
            'switch_inline_query' => 'switch-inline-query',
            'switch_inline_query_current_chat' => 'switch-inline-query-current-chat',
            'switch_inline_query_chosen_chat' => ['query' => 'dg'],
            'copy_text' => ['text' => 'Copy it!'],
            'callback_game' => [],
            'pay' => true,
        ], null, InlineKeyboardButton::class);

        $this->assertSame('test', $button->text);
        $this->assertSame('https://example.com', $button->url);
        $this->assertSame('callback-data', $button->callbackData);
        $this->assertSame('https://example.com/test', $button->webApp?->url);
        $this->assertSame('https://example.com/login', $button->loginUrl?->url);
        $this->assertSame('switch-inline-query', $button->switchInlineQuery);
        $this->assertSame('switch-inline-query-current-chat', $button->switchInlineQueryCurrentChat);
        $this->assertSame('dg', $button->switchInlineQueryChosenChat->query);
        $this->assertSame('Copy it!', $button->copyText->text);
        $this->assertInstanceOf(CallbackGame::class, $button->callbackGame);
        $this->assertTrue($button->pay);
    }
}

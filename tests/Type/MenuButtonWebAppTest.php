<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\MenuButtonWebApp;
use Vjik\TelegramBot\Api\Type\WebAppInfo;

final class MenuButtonWebAppTest extends TestCase
{
    public function testBase(): void
    {
        $webApp = new WebAppInfo('https://example.com/');
        $button = new MenuButtonWebApp('test', $webApp);

        $this->assertSame('web_app', $button->getType());
        $this->assertSame('test', $button->text);
        $this->assertSame($webApp, $button->webApp);

        $this->assertSame([
            'type' => 'web_app',
            'text' => 'test',
            'web_app' => $webApp->toRequestArray(),
        ], $button->toRequestArray());
    }

    public function testFromTelegramResult(): void
    {
        $button = (new ObjectFactory())->create([
            'type' => 'web_app',
            'text' => 'test',
            'web_app' => [
                'url' => 'https://example.com',
            ],
        ], null, MenuButtonWebApp::class);

        $this->assertSame('web_app', $button->getType());
        $this->assertSame('test', $button->text);
        $this->assertSame('https://example.com', $button->webApp->url);
    }
}

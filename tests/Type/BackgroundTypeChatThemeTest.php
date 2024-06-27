<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\BackgroundTypeChatTheme;

final class BackgroundTypeChatThemeTest extends TestCase
{
    public function testBase(): void
    {
        $type = new BackgroundTypeChatTheme('dark');

        $this->assertSame('chat_theme', $type->getType());
        $this->assertSame('dark', $type->themeName);
    }

    public function testFromTelegramResult(): void
    {
        $type = BackgroundTypeChatTheme::fromTelegramResult([
            'type' => 'chat_theme',
            'theme_name' => 'dark',
        ]);

        $this->assertSame('chat_theme', $type->getType());
        $this->assertSame('dark', $type->themeName);
    }
}

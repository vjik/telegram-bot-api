<?php

declare(strict_types=1);

namespace Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\BackgroundTypeChatTheme;
use Vjik\TelegramBot\Api\Type\ChatBackground;

final class ChatBackgroundTest extends TestCase
{
    public function testBase(): void
    {
        $backgroundType = new BackgroundTypeChatTheme('dark');
        $chatBackground = new ChatBackground($backgroundType);

        $this->assertSame($backgroundType, $chatBackground->type);
    }

    public function testFromTelegramResult(): void
    {
        $chatBackground = ChatBackground::fromTelegramResult([
            'type' => [
                'type' => 'chat_theme',
                'theme_name' => 'dark',
            ],
        ]);

        $this->assertInstanceOf(BackgroundTypeChatTheme::class, $chatBackground->type);
        $this->assertSame('dark', $chatBackground->type->themeName);
        $this->assertSame('chat_theme', $chatBackground->type->getType());
    }
}

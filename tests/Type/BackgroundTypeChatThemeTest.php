<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\BackgroundTypeChatTheme;

use function PHPUnit\Framework\assertSame;

final class BackgroundTypeChatThemeTest extends TestCase
{
    public function testBase(): void
    {
        $type = new BackgroundTypeChatTheme('dark');

        assertSame('chat_theme', $type->getType());
        assertSame('dark', $type->themeName);
    }

    public function testFromTelegramResult(): void
    {
        $type = (new ObjectFactory())->create([
            'type' => 'chat_theme',
            'theme_name' => 'dark',
        ], null, BackgroundTypeChatTheme::class);

        assertSame('chat_theme', $type->getType());
        assertSame('dark', $type->themeName);
    }
}

<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\ParseResult\ValueProcessor;

use Vjik\TelegramBot\Api\Type\BackgroundTypeChatTheme;
use Vjik\TelegramBot\Api\Type\BackgroundTypeFill;
use Vjik\TelegramBot\Api\Type\BackgroundTypePattern;
use Vjik\TelegramBot\Api\Type\BackgroundTypeWallpaper;

final readonly class BackgroundTypeValue extends InterfaceValue
{
    public function getTypeKey(): string
    {
        return 'type';
    }

    public function getClassMap(): array
    {
        return [
            'fill' => BackgroundTypeFill::class,
            'wallpaper' => BackgroundTypeWallpaper::class,
            'pattern' => BackgroundTypePattern::class,
            'chat_theme' => BackgroundTypeChatTheme::class,
        ];
    }

    public function getUnknownTypeMessage(): string
    {
        return 'Unknown background type.';
    }
}

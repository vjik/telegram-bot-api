<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

final readonly class BackgroundTypeFactory
{
    public static function fromTelegramResult(mixed $result): BackgroundType
    {
        ValueHelper::assertArrayResult($result);
        return match (ValueHelper::getString($result, 'type')) {
            'fill' => BackgroundTypeFill::fromTelegramResult($result),
            'wallpaper' => BackgroundTypeWallpaper::fromTelegramResult($result),
            'pattern' => BackgroundTypePattern::fromTelegramResult($result),
            'chat_theme' => BackgroundTypeChatTheme::fromTelegramResult($result),
            default => throw new TelegramParseResultException('Unknown background type.'),
        };
    }
}

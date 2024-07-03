<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

final readonly class BackgroundTypeFactory
{
    public static function fromTelegramResult(mixed $result, mixed $raw = null): BackgroundType
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return match (ValueHelper::getString($result, 'type', $raw)) {
            'fill' => BackgroundTypeFill::fromTelegramResult($result, $raw),
            'wallpaper' => BackgroundTypeWallpaper::fromTelegramResult($result, $raw),
            'pattern' => BackgroundTypePattern::fromTelegramResult($result, $raw),
            'chat_theme' => BackgroundTypeChatTheme::fromTelegramResult($result, $raw),
            default => throw new TelegramParseResultException('Unknown background type.', $raw),
        };
    }
}

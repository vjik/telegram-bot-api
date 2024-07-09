<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#backgroundtypechattheme
 */
final readonly class BackgroundTypeChatTheme implements BackgroundType
{
    public function __construct(
        public string $themeName,
    ) {}

    public function getType(): string
    {
        return 'chat_theme';
    }
}

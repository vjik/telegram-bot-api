<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#backgroundtypechattheme
 */
final readonly class BackgroundTypeChatTheme implements BackgroundType
{
    public function __construct(
        public string $type,
        public string $themeName,
    ) {
    }

    public function getType(): string
    {
        return 'chat_theme';
    }

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            ValueHelper::getString($result, 'type'),
            ValueHelper::getString($result, 'theme_name'),
        );
    }
}

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
        public string $themeName,
    ) {
    }

    public function getType(): string
    {
        return 'chat_theme';
    }

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            ValueHelper::getString($result, 'theme_name', $raw),
        );
    }
}

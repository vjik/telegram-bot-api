<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#loginurl
 */
final readonly class LoginUrl
{
    public function __construct(
        public string $url,
        public ?string $forwardText,
        public ?string $botUsername,
        public ?bool $requestWriteAccess,
    ) {
    }

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            ValueHelper::getString($result, 'url'),
            ValueHelper::getStringOrNull($result, 'forward_text'),
            ValueHelper::getStringOrNull($result, 'bot_username'),
            ValueHelper::getBooleanOrNull($result, 'request_write_access'),
        );
    }
}

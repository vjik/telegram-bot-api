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
        public ?string $forwardText = null,
        public ?string $botUsername = null,
        public ?bool $requestWriteAccess = null,
    ) {
    }

    public function toRequestArray(): array
    {
        return array_filter(
            [
                'url' => $this->url,
                'forward_text' => $this->forwardText,
                'bot_username' => $this->botUsername,
                'request_write_access' => $this->requestWriteAccess,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            ValueHelper::getString($result, 'url', $raw),
            ValueHelper::getStringOrNull($result, 'forward_text', $raw),
            ValueHelper::getStringOrNull($result, 'bot_username', $raw),
            ValueHelper::getBooleanOrNull($result, 'request_write_access', $raw),
        );
    }
}

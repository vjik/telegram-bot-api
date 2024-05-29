<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

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
}

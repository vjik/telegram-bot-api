<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#responseparameters
 */
final readonly class ResponseParameters
{
    public function __construct(
        public ?int $migrateToChatId,
        public ?int $retryAfter,
    ) {
    }
}

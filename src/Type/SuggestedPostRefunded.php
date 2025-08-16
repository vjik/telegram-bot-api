<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#suggestedpostrefunded
 *
 * @api
 */
final readonly class SuggestedPostRefunded
{
    public function __construct(
        public string $reason,
        public ?Message $suggestedPostMessage = null,
    ) {}
}

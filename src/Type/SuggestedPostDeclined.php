<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#suggestedpostdeclined
 *
 * @api
 */
final readonly class SuggestedPostDeclined
{
    public function __construct(
        public ?Message $suggestedPostMessage = null,
        public ?string $comment = null,
    ) {}
}

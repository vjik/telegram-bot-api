<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#suggestedpostapproved
 *
 * @api
 */
final readonly class SuggestedPostApproved
{
    public function __construct(
        public int $sendDate,
        public ?Message $suggestedPostMessage = null,
        public ?SuggestedPostPrice $price = null,
    ) {}
}

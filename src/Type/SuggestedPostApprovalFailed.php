<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#suggestedpostapprovalfailed
 *
 * @api
 */
final readonly class SuggestedPostApprovalFailed
{
    public function __construct(
        public SuggestedPostPrice $price,
        public ?Message $suggestedPostMessage = null,
    ) {}
}

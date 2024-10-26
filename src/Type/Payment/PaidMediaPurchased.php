<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Payment;

use Vjik\TelegramBot\Api\Type\User;

/**
 * @see https://core.telegram.org/bots/api#paidmediapurchased
 */
final readonly class PaidMediaPurchased
{
    public function __construct(
        public User $from,
        // As of 26.10.2024, Telegram Bot API documentation contains incorrect name "paid_media_payload".
        // Real API use "payload" name.
        public string $payload,
    ) {}
}

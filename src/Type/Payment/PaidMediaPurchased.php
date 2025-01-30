<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Payment;

use Vjik\TelegramBot\Api\Type\User;

/**
 * @see https://core.telegram.org/bots/api#paidmediapurchased
 *
 * @api
 */
final readonly class PaidMediaPurchased
{
    public function __construct(
        public User $from,
        public string $paidMediaPayload,
    ) {}
}

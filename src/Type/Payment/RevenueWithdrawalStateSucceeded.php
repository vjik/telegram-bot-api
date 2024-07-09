<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Payment;

use DateTimeImmutable;

/**
 * @see https://core.telegram.org/bots/api#revenuewithdrawalstatesucceeded
 */
final readonly class RevenueWithdrawalStateSucceeded implements RevenueWithdrawalState
{
    public function __construct(
        public DateTimeImmutable $date,
        public string $url,
    ) {}

    public function getType(): string
    {
        return 'succeeded';
    }
}

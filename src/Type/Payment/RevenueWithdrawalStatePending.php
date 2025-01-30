<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Payment;

/**
 * @see https://core.telegram.org/bots/api#revenuewithdrawalstatepending
 *
 * @api
 */
final readonly class RevenueWithdrawalStatePending implements RevenueWithdrawalState
{
    public function getType(): string
    {
        return 'pending';
    }
}

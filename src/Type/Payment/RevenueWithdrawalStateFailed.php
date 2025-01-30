<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Payment;

/**
 * @see https://core.telegram.org/bots/api#revenuewithdrawalstatefailed
 *
 * @api
 */
final readonly class RevenueWithdrawalStateFailed implements RevenueWithdrawalState
{
    public function getType(): string
    {
        return 'failed';
    }
}

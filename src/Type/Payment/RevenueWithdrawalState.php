<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Payment;

/**
 * @see https://core.telegram.org/bots/api#revenuewithdrawalstate
 *
 * @api
 */
interface RevenueWithdrawalState
{
    public function getType(): string;
}

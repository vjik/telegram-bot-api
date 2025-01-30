<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Payment;

/**
 * @see https://core.telegram.org/bots/api#transactionpartner
 *
 * @api
 */
interface TransactionPartner
{
    public function getType(): string;
}

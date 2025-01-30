<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Payment;

/**
 * @see https://core.telegram.org/bots/api#transactionpartnerother
 *
 * @api
 */
final readonly class TransactionPartnerOther implements TransactionPartner
{
    public function getType(): string
    {
        return 'other';
    }
}

<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Payment;

/**
 * @see https://core.telegram.org/bots/api#transactionpartnerfragment
 *
 * @api
 */
final readonly class TransactionPartnerFragment implements TransactionPartner
{
    public function __construct(
        public ?RevenueWithdrawalState $withdrawalState = null,
    ) {}

    public function getType(): string
    {
        return 'fragment';
    }
}

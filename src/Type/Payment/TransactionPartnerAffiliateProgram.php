<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Payment;

use Vjik\TelegramBot\Api\Type\User;

/**
 * @see https://core.telegram.org/bots/api#transactionpartneraffiliateprogram
 *
 * @api
 */
final readonly class TransactionPartnerAffiliateProgram implements TransactionPartner
{
    public function __construct(
        public int $commissionPerMille,
        public ?User $sponsorUser = null,
    ) {}

    public function getType(): string
    {
        return 'affiliate_program';
    }
}

<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Payment;

/**
 * @see https://core.telegram.org/bots/api#transactionpartnertelegramads
 *
 * @api
 */
final readonly class TransactionPartnerTelegramAds implements TransactionPartner
{
    public function getType(): string
    {
        return 'telegram_ads';
    }
}

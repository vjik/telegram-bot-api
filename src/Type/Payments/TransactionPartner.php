<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Payments;

/**
 * @see https://core.telegram.org/bots/api#transactionpartner
 */
interface TransactionPartner
{
    public function getType(): string;
}

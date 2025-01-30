<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Payment;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ArrayOfObjectsValue;

/**
 * @see https://core.telegram.org/bots/api#startransactions
 *
 * @api
 */
final readonly class StarTransactions
{
    /**
     * @param StarTransaction[] $transactions
     */
    public function __construct(
        #[ArrayOfObjectsValue(StarTransaction::class)]
        public array $transactions,
    ) {}
}

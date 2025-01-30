<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Payment;

/**
 * @see https://core.telegram.org/bots/api#invoice
 *
 * @api
 */
final readonly class Invoice
{
    public function __construct(
        public string $title,
        public string $description,
        public string $startParameter,
        public string $currency,
        public int $totalAmount,
    ) {}
}

<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Payment;

use Vjik\TelegramBot\Api\Type\User;

/**
 * @see https://core.telegram.org/bots/api#precheckoutquery
 *
 * @api
 */
final readonly class PreCheckoutQuery
{
    public function __construct(
        public string $id,
        public User $from,
        public string $currency,
        public int $totalAmount,
        public string $invoicePayload,
        public ?string $shippingOptionId = null,
        public ?OrderInfo $orderInfo = null,
    ) {}
}

<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Payment;

/**
 * @see https://core.telegram.org/bots/api#refundedpayment
 */
final readonly class RefundedPayment
{
    public function __construct(
        public string $currency,
        public int $totalAmount,
        public string $invoicePayload,
        public string $telegramPaymentChargeId,
        public ?string $providerPaymentChargeId = null,
    ) {}
}

<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Payments;

/**
 * @see https://core.telegram.org/bots/api#successfulpayment
 */
final readonly class SuccessfulPayment
{
    public function __construct(
        public string $currency,
        public int $totalAmount,
        public string $invoicePayload,
        public ?string $shippingOptionId,
        public ?OrderInfo $orderInfo,
        public string $telegramPaymentChargeId,
        public string $providerPaymentChargeId,
    ) {
    }
}

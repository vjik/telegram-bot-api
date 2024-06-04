<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Payments;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#successfulpayment
 */
final readonly class SuccessfulPayment
{
    public function __construct(
        public string $currency,
        public int $totalAmount,
        public string $invoicePayload,
        public string $telegramPaymentChargeId,
        public string $providerPaymentChargeId,
        public ?string $shippingOptionId = null,
        public ?OrderInfo $orderInfo = null,
    ) {
    }

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            ValueHelper::getString($result, 'currency'),
            ValueHelper::getInteger($result, 'total_amount'),
            ValueHelper::getString($result, 'invoice_payload'),
            ValueHelper::getString($result, 'telegram_payment_charge_id'),
            ValueHelper::getString($result, 'provider_payment_charge_id'),
            ValueHelper::getStringOrNull($result, 'shipping_option_id'),
            array_key_exists('order_info', $result)
                ? OrderInfo::fromTelegramResult($result['order_info'])
                : null,
        );
    }
}

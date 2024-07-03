<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Payment;

use Vjik\TelegramBot\Api\ParseResult\NotFoundKeyInResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;
use Vjik\TelegramBot\Api\Type\User;

/**
 * @see https://core.telegram.org/bots/api#precheckoutquery
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
    ) {
    }

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            ValueHelper::getString($result, 'id', $raw),
            array_key_exists('from', $result)
                ? User::fromTelegramResult($result['from'], $raw)
                : throw new NotFoundKeyInResultException('from', $raw),
            ValueHelper::getString($result, 'currency', $raw),
            ValueHelper::getInteger($result, 'total_amount', $raw),
            ValueHelper::getString($result, 'invoice_payload', $raw),
            ValueHelper::getStringOrNull($result, 'shipping_option_id', $raw),
            array_key_exists('order_info', $result)
                ? OrderInfo::fromTelegramResult($result['order_info'], $raw)
                : null,
        );
    }
}

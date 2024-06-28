<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Payment;

use Vjik\TelegramBot\Api\ParseResult\NotFoundKeyInResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;
use Vjik\TelegramBot\Api\Type\User;

/**
 * @see https://core.telegram.org/bots/api#shippingquery
 */
final readonly class ShippingQuery
{
    public function __construct(
        public string $id,
        public User $from,
        public string $invoicePayload,
        public ShippingAddress $shippingAddress,
    ) {
    }

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            ValueHelper::getString($result, 'id'),
            array_key_exists('from', $result)
                ? User::fromTelegramResult($result['from'])
                : throw new NotFoundKeyInResultException('from'),
            ValueHelper::getString($result, 'invoice_payload'),
            array_key_exists('shipping_address', $result)
                ? ShippingAddress::fromTelegramResult($result['shipping_address'])
                : throw new NotFoundKeyInResultException('shipping_address'),
        );
    }
}

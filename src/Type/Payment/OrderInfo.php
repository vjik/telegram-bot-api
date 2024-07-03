<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Payment;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#orderinfo
 */
final readonly class OrderInfo
{
    public function __construct(
        public ?string $name = null,
        public ?string $phoneNumber = null,
        public ?string $email = null,
        public ?ShippingAddress $shippingAddress = null,
    ) {
    }

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            ValueHelper::getStringOrNull($result, 'name', $raw),
            ValueHelper::getStringOrNull($result, 'phone_number', $raw),
            ValueHelper::getStringOrNull($result, 'email', $raw),
            array_key_exists('shipping_address', $result)
                ? ShippingAddress::fromTelegramResult($result['shipping_address'], $raw)
                : null,
        );
    }
}

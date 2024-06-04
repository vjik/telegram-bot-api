<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Payments;

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

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            ValueHelper::getStringOrNull($result, 'name'),
            ValueHelper::getStringOrNull($result, 'phone_number'),
            ValueHelper::getStringOrNull($result, 'email'),
            array_key_exists('shipping_address', $result)
                ? ShippingAddress::fromTelegramResult($result['shipping_address'])
                : null,
        );
    }
}

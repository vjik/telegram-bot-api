<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Payments;

/**
 * @see https://core.telegram.org/bots/api#orderinfo
 */
final readonly class OrderInfo
{
    public function __construct(
        public ?string $name,
        public ?string $phoneNumber,
        public ?string $email,
        public ?ShippingAddress $shippingAddress,
    ) {
    }
}

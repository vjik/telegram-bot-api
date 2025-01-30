<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Payment;

/**
 * @see https://core.telegram.org/bots/api#orderinfo
 *
 * @api
 */
final readonly class OrderInfo
{
    public function __construct(
        public ?string $name = null,
        public ?string $phoneNumber = null,
        public ?string $email = null,
        public ?ShippingAddress $shippingAddress = null,
    ) {}
}

<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Payments;

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
}

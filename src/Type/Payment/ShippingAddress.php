<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Payment;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#shippingaddress
 */
final readonly class ShippingAddress
{
    public function __construct(
        public string $countryCode,
        public string $state,
        public string $city,
        public string $streetLine1,
        public string $streetLine2,
        public string $postCode,
    ) {
    }

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            ValueHelper::getString($result, 'country_code', $raw),
            ValueHelper::getString($result, 'state', $raw),
            ValueHelper::getString($result, 'city', $raw),
            ValueHelper::getString($result, 'street_line1', $raw),
            ValueHelper::getString($result, 'street_line2', $raw),
            ValueHelper::getString($result, 'post_code', $raw),
        );
    }
}

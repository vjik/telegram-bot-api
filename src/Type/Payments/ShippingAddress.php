<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Payments;

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

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            ValueHelper::getString($result, 'country_code'),
            ValueHelper::getString($result, 'state'),
            ValueHelper::getString($result, 'city'),
            ValueHelper::getString($result, 'street_line1'),
            ValueHelper::getString($result, 'street_line2'),
            ValueHelper::getString($result, 'post_code'),
        );
    }
}

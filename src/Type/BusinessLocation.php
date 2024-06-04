<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#businesslocation
 */
final class BusinessLocation
{
    public function __construct(
        public string $address,
        public ?Location $location = null,
    ) {
    }

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            ValueHelper::getString($result, 'address'),
            array_key_exists('location', $result)
                ? Location::fromTelegramResult($result['location'])
                : null,
        );
    }
}

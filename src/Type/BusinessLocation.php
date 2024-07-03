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

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            ValueHelper::getString($result, 'address', $raw),
            array_key_exists('location', $result)
                ? Location::fromTelegramResult($result['location'], $raw)
                : null,
        );
    }
}

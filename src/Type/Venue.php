<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\NotFoundKeyInResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#venue
 */
final readonly class Venue
{
    public function __construct(
        public Location $location,
        public string $title,
        public string $address,
        public ?string $foursquareId = null,
        public ?string $foursquareType = null,
        public ?string $googlePlaceId = null,
        public ?string $googlePlaceType = null,
    ) {
    }

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            array_key_exists('location', $result)
                ? Location::fromTelegramResult($result['location'], $raw)
                : throw new NotFoundKeyInResultException('location', $raw),
            ValueHelper::getString($result, 'title', $raw),
            ValueHelper::getString($result, 'address', $raw),
            ValueHelper::getStringOrNull($result, 'foursquare_id', $raw),
            ValueHelper::getStringOrNull($result, 'foursquare_type', $raw),
            ValueHelper::getStringOrNull($result, 'google_place_id', $raw),
            ValueHelper::getStringOrNull($result, 'google_place_type', $raw),
        );
    }
}

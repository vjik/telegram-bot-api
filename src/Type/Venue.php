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

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            array_key_exists('location', $result)
                ? Location::fromTelegramResult($result['location'])
                : throw new NotFoundKeyInResultException('location'),
            ValueHelper::getString($result, 'title'),
            ValueHelper::getString($result, 'address'),
            ValueHelper::getStringOrNull($result, 'foursquare_id'),
            ValueHelper::getStringOrNull($result, 'foursquare_type'),
            ValueHelper::getStringOrNull($result, 'google_place_id'),
            ValueHelper::getStringOrNull($result, 'google_place_type'),
        );
    }
}

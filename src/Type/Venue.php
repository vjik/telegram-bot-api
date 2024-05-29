<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#venue
 */
final readonly class Venue
{
    public function __construct(
        public Location $location,
        public string $title,
        public string $address,
        public ?string $foursquareId,
        public ?string $foursquareType,
        public ?string $googlePlaceId,
        public ?string $googlePlaceType,
    ) {
    }
}

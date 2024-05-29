<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#location
 */
final readonly class Location
{
    public function __construct(
        public float $latitude,
        public float $longitude,
        public ?float $horizontalAccuracy,
        public ?int $livePeriod,
        public ?int $heading,
        public ?int $proximityAlertRadius,
    ) {
    }
}

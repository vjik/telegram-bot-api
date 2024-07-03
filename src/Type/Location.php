<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#location
 */
final readonly class Location
{
    public function __construct(
        public float $latitude,
        public float $longitude,
        public ?float $horizontalAccuracy = null,
        public ?int $livePeriod = null,
        public ?int $heading = null,
        public ?int $proximityAlertRadius = null,
    ) {
    }

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            ValueHelper::getFloat($result, 'latitude', $raw),
            ValueHelper::getFloat($result, 'longitude', $raw),
            ValueHelper::getFloatOrNull($result, 'horizontal_accuracy', $raw),
            ValueHelper::getIntegerOrNull($result, 'live_period', $raw),
            ValueHelper::getIntegerOrNull($result, 'heading', $raw),
            ValueHelper::getIntegerOrNull($result, 'proximity_alert_radius', $raw),
        );
    }
}

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
        public ?float $horizontalAccuracy,
        public ?int $livePeriod,
        public ?int $heading,
        public ?int $proximityAlertRadius,
    ) {
    }

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            ValueHelper::getFloat($result, 'latitude'),
            ValueHelper::getFloat($result, 'longitude'),
            ValueHelper::getFloatOrNull($result, 'horizontal_accuracy'),
            ValueHelper::getIntegerOrNull($result, 'live_period'),
            ValueHelper::getIntegerOrNull($result, 'heading'),
            ValueHelper::getIntegerOrNull($result, 'proximity_alert_radius'),
        );
    }
}

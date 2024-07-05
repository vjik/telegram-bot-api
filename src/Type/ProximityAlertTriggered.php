<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#proximityalerttriggered
 */
final readonly class ProximityAlertTriggered
{
    public function __construct(
        public User $traveler,
        public User $watcher,
        public int $distance,
    ) {
    }
}

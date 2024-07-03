<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\NotFoundKeyInResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

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

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            array_key_exists('traveler', $result)
                ? User::fromTelegramResult($result['traveler'], $raw)
                : throw new NotFoundKeyInResultException('traveler', $raw),
            array_key_exists('watcher', $result)
                ? User::fromTelegramResult($result['watcher'], $raw)
                : throw new NotFoundKeyInResultException('watcher', $raw),
            ValueHelper::getInteger($result, 'distance', $raw),
        );
    }
}

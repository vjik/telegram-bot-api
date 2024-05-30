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

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            array_key_exists('traveler', $result)
                ? User::fromTelegramResult($result['traveler'])
                : throw new NotFoundKeyInResultException('traveler'),
            array_key_exists('watcher', $result)
                ? User::fromTelegramResult($result['watcher'])
                : throw new NotFoundKeyInResultException('watcher'),
            ValueHelper::getInteger($result, 'distance'),
        );
    }
}

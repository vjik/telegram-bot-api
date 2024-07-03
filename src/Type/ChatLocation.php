<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\NotFoundKeyInResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#chatlocation
 */
final readonly class ChatLocation
{
    public function __construct(
        public Location $location,
        public string $address,
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
            ValueHelper::getString($result, 'address', $raw),
        );
    }
}

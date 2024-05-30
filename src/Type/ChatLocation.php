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

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            array_key_exists('location', $result)
                ? Location::fromTelegramResult($result['location'])
                : throw new NotFoundKeyInResultException('location'),
            ValueHelper::getString($result, 'address'),
        );
    }
}

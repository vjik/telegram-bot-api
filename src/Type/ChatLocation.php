<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#chatlocation
 */
final readonly class ChatLocation
{
    public function __construct(
        public Location $location,
        public string $address,
    ) {}
}

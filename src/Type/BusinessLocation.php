<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#businesslocation
 *
 * @api
 */
final readonly class BusinessLocation
{
    public function __construct(
        public string $address,
        public ?Location $location = null,
    ) {}
}

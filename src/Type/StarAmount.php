<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#staramount
 *
 * @api
 */
final readonly class StarAmount
{
    public function __construct(
        public int $amount,
        public ?int $nanostarAmount = null,
    ) {}
}

<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#chatboostadded
 *
 * @api
 */
final readonly class ChatBoostAdded
{
    public function __construct(
        public int $boostCount,
    ) {}
}

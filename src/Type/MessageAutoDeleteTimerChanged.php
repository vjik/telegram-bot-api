<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#messageautodeletetimerchanged
 *
 * @api
 */
final readonly class MessageAutoDeleteTimerChanged
{
    public function __construct(
        public int $messageAutoDeleteTime,
    ) {}
}

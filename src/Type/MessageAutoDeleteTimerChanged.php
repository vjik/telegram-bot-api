<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#messageautodeletetimerchanged
 */
final readonly class MessageAutoDeleteTimerChanged
{
    public function __construct(
        public int $messageAutoDeleteTime,
    ) {
    }

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            ValueHelper::getInteger($result, 'message_auto_delete_time'),
        );
    }
}

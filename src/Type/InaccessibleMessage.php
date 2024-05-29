<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#inaccessiblemessage
 */
final readonly class InaccessibleMessage
{
    public function __construct(
        public Chat $chat,
        public int $messageId,
        public int $date,
    ) {
    }
}

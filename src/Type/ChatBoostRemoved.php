<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use DateTimeImmutable;

/**
 * @see https://core.telegram.org/bots/api#chatboostremoved
 *
 * @api
 */
final readonly class ChatBoostRemoved
{
    public function __construct(
        public Chat $chat,
        public string $boostId,
        public DateTimeImmutable $removeDate,
        public ChatBoostSource $source,
    ) {}
}

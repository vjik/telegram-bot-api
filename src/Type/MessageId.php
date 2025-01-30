<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * https://core.telegram.org/bots/api#messageid
 *
 * @api
 */
final readonly class MessageId
{
    public function __construct(
        public int $messageId,
    ) {}
}

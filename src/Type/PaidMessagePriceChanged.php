<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#paidmessagepricechanged
 *
 * @api
 */
final readonly class PaidMessagePriceChanged
{
    public function __construct(
        public int $paidMessageStarCount,
    ) {}
}

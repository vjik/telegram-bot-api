<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#directmessagepricechanged
 *
 * @api
 */
final readonly class DirectMessagePriceChanged
{
    public function __construct(
        public bool $areDirectMessagesEnabled,
        public ?int $directMessageStarCount = null,
    ) {}
}

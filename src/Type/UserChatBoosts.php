<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ArrayOfObjectsValue;

/**
 * @see https://core.telegram.org/bots/api#userchatboosts
 *
 * @api
 */
final readonly class UserChatBoosts
{
    /**
     * @param ChatBoost[] $boosts
     */
    public function __construct(
        #[ArrayOfObjectsValue(ChatBoost::class)]
        public array $boosts,
    ) {}
}

<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Game;

/**
 * @see https://core.telegram.org/bots/api#callbackgame
 *
 * @api
 */
final readonly class CallbackGame
{
    public function toRequestArray(): array
    {
        return [];
    }
}

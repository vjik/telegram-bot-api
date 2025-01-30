<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Game;

use Vjik\TelegramBot\Api\Type\User;

/**
 * @see https://core.telegram.org/bots/api#gamehighscore
 *
 * @api
 */
final readonly class GameHighScore
{
    public function __construct(
        public int $position,
        public User $user,
        public int $score,
    ) {}
}

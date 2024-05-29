<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#giveawaycompleted
 */
final readonly class GiveawayCompleted
{
    public function __construct(
        public int $winner_count,
        public ?int $unclaimedPrizeCount,
        public ?Message $giveawayMessage,
    ) {
    }
}

<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#giveawaycompleted
 */
final readonly class GiveawayCompleted
{
    public function __construct(
        public int $winnerCount,
        public ?int $unclaimedPrizeCount = null,
        public ?Message $giveawayMessage = null,
    ) {
    }

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            ValueHelper::getInteger($result, 'winner_count'),
            ValueHelper::getIntegerOrNull($result, 'unclaimed_prize_count'),
            array_key_exists('giveaway_message', $result)
                ? Message::fromTelegramResult($result['giveaway_message'])
                : null,
        );
    }
}

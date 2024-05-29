<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#giveawaywinners
 */
final readonly class GiveawayWinners
{
    /**
     * @param User[] $winners
     */
    public function __construct(
        public Chat $chat,
        public int $giveawayMessageId,
        public int $winnersSelectionDate,
        public int $winnerCount,
        public array $winners,
        public ?int $additionalChatCount,
        public ?int $premiumSubscriptionMonthCount,
        public ?int $unclaimedPrizeCount,
        public ?true $onlyNewMembers,
        public ?true $wasRefunded,
        public ?string $prizeDescription,
    ) {
    }
}

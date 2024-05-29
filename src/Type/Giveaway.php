<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#giveaway
 */
final readonly class Giveaway
{
    /**
     * @param Chat[] $chats
     * @param string[]|null $countryCodes
     */
    public function __construct(
        public array $chats,
        public int $winnersSelectionDate,
        public int $winnerCount,
        public ?true $onlyNewMembers,
        public ?true $hasPublicWinners,
        public ?string $prizeDescription,
        public ?array $countryCodes,
        public ?int $premiumSubscriptionMonthCount,
    ) {
    }
}

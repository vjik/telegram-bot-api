<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use DateTimeImmutable;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ArrayOfObjectsValue;

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
        public DateTimeImmutable $winnersSelectionDate,
        public int $winnerCount,
        #[ArrayOfObjectsValue(User::class)]
        public array $winners,
        public ?int $additionalChatCount = null,
        public ?int $premiumSubscriptionMonthCount = null,
        public ?int $unclaimedPrizeCount = null,
        public ?true $onlyNewMembers = null,
        public ?true $wasRefunded = null,
        public ?string $prizeDescription = null,
    ) {}
}

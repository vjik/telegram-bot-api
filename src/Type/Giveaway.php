<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

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

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            array_map(
                static fn($p) => Chat::fromTelegramResult($p),
                ValueHelper::getArray($result, 'chats')
            ),
            ValueHelper::getInteger($result, 'winners_selection_date'),
            ValueHelper::getInteger($result, 'winner_count'),
            ValueHelper::getTrueOrNull($result, 'only_new_members'),
            ValueHelper::getTrueOrNull($result, 'has_public_winners'),
            ValueHelper::getStringOrNull($result, 'prize_description'),
            ValueHelper::getArrayOfStringsOrNull($result, 'country_codes'),
            ValueHelper::getIntegerOrNull($result, 'premium_subscription_month_count'),
        );
    }
}

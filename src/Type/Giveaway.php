<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use DateTimeImmutable;
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
        public DateTimeImmutable $winnersSelectionDate,
        public int $winnerCount,
        public ?true $onlyNewMembers = null,
        public ?true $hasPublicWinners = null,
        public ?string $prizeDescription = null,
        public ?array $countryCodes = null,
        public ?int $premiumSubscriptionMonthCount = null,
    ) {
    }

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            array_map(
                static fn($p) => Chat::fromTelegramResult($p, $raw),
                ValueHelper::getArray($result, 'chats', $raw)
            ),
            ValueHelper::getDateTimeImmutable($result, 'winners_selection_date', $raw),
            ValueHelper::getInteger($result, 'winner_count', $raw),
            ValueHelper::getTrueOrNull($result, 'only_new_members', $raw),
            ValueHelper::getTrueOrNull($result, 'has_public_winners', $raw),
            ValueHelper::getStringOrNull($result, 'prize_description', $raw),
            ValueHelper::getArrayOfStringsOrNull($result, 'country_codes', $raw),
            ValueHelper::getIntegerOrNull($result, 'premium_subscription_month_count', $raw),
        );
    }
}

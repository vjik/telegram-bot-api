<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use DateTimeImmutable;
use Vjik\TelegramBot\Api\ParseResult\NotFoundKeyInResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

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
        public array $winners,
        public ?int $additionalChatCount = null,
        public ?int $premiumSubscriptionMonthCount = null,
        public ?int $unclaimedPrizeCount = null,
        public ?true $onlyNewMembers = null,
        public ?true $wasRefunded = null,
        public ?string $prizeDescription = null,
    ) {
    }

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            array_key_exists('chat', $result)
                ? Chat::fromTelegramResult($result['chat'], $raw)
                : throw new NotFoundKeyInResultException('chat', $raw),
            ValueHelper::getInteger($result, 'giveaway_message_id', $raw),
            ValueHelper::getDateTimeImmutable($result, 'winners_selection_date', $raw),
            ValueHelper::getInteger($result, 'winner_count', $raw),
            array_map(
                static fn($p) => User::fromTelegramResult($p, $raw),
                ValueHelper::getArray($result, 'winners', $raw)
            ),
            ValueHelper::getIntegerOrNull($result, 'additional_chat_count', $raw),
            ValueHelper::getIntegerOrNull($result, 'premium_subscription_month_count', $raw),
            ValueHelper::getIntegerOrNull($result, 'unclaimed_prize_count', $raw),
            ValueHelper::getTrueOrNull($result, 'only_new_members', $raw),
            ValueHelper::getTrueOrNull($result, 'was_refunded', $raw),
            ValueHelper::getStringOrNull($result, 'prize_description', $raw),
        );
    }
}

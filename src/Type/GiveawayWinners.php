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
        public ?int $additionalChatCount,
        public ?int $premiumSubscriptionMonthCount,
        public ?int $unclaimedPrizeCount,
        public ?true $onlyNewMembers,
        public ?true $wasRefunded,
        public ?string $prizeDescription,
    ) {
    }

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            array_key_exists('chat', $result)
                ? Chat::fromTelegramResult($result['chat'])
                : throw new NotFoundKeyInResultException('chat'),
            ValueHelper::getInteger($result, 'giveaway_message_id'),
            ValueHelper::getDateTimeImmutable($result, 'winners_selection_date'),
            ValueHelper::getInteger($result, 'winner_count'),
            array_map(
                static fn($p) => User::fromTelegramResult($p),
                ValueHelper::getArray($result, 'winners')
            ),
            ValueHelper::getIntegerOrNull($result, 'additional_chat_count'),
            ValueHelper::getIntegerOrNull($result, 'premium_subscription_month_count'),
            ValueHelper::getIntegerOrNull($result, 'unclaimed_prize_count'),
            ValueHelper::getTrueOrNull($result, 'only_new_members'),
            ValueHelper::getTrueOrNull($result, 'was_refunded'),
            ValueHelper::getStringOrNull($result, 'prize_description'),
        );
    }
}

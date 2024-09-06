<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\Chat;
use Vjik\TelegramBot\Api\Type\GiveawayWinners;
use Vjik\TelegramBot\Api\Type\User;

final class GiveawayWinnersTest extends TestCase
{
    public function testBase(): void
    {
        $chat = new Chat(1, 'private');
        $date = new DateTimeImmutable();
        $user = new User(1, false, 'first_name');
        $giveawayWinners = new GiveawayWinners($chat, 2, $date, 5, [$user]);

        $this->assertSame($chat, $giveawayWinners->chat);
        $this->assertSame(2, $giveawayWinners->giveawayMessageId);
        $this->assertSame($date, $giveawayWinners->winnersSelectionDate);
        $this->assertSame(5, $giveawayWinners->winnerCount);
        $this->assertSame([$user], $giveawayWinners->winners);
        $this->assertNull($giveawayWinners->additionalChatCount);
        $this->assertNull($giveawayWinners->premiumSubscriptionMonthCount);
        $this->assertNull($giveawayWinners->unclaimedPrizeCount);
        $this->assertNull($giveawayWinners->onlyNewMembers);
        $this->assertNull($giveawayWinners->wasRefunded);
        $this->assertNull($giveawayWinners->prizeDescription);
        $this->assertNull($giveawayWinners->prizeStarCount);
    }

    public function testFromTelegramResult(): void
    {
        $giveawayWinners = (new ObjectFactory())->create([
            'chat' => ['id' => 1, 'type' => 'private'],
            'giveaway_message_id' => 2,
            'winners_selection_date' => 124125122,
            'winner_count' => 5,
            'winners' => [['id' => 33, 'is_bot' => false, 'first_name' => 'Sergei']],
            'additional_chat_count' => 12,
            'prize_star_count' => 99,
            'premium_subscription_month_count' => 7,
            'unclaimed_prize_count' => 3,
            'only_new_members' => true,
            'was_refunded' => true,
            'prize_description' => 'Desc',
        ], null, GiveawayWinners::class);

        $this->assertSame(1, $giveawayWinners->chat->id);
        $this->assertSame(2, $giveawayWinners->giveawayMessageId);
        $this->assertSame(124125122, $giveawayWinners->winnersSelectionDate->getTimestamp());
        $this->assertSame(5, $giveawayWinners->winnerCount);

        $this->assertCount(1, $giveawayWinners->winners);
        $this->assertSame(33, $giveawayWinners->winners[0]->id);

        $this->assertSame(12, $giveawayWinners->additionalChatCount);
        $this->assertSame(7, $giveawayWinners->premiumSubscriptionMonthCount);
        $this->assertSame(3, $giveawayWinners->unclaimedPrizeCount);
        $this->assertTrue($giveawayWinners->onlyNewMembers);
        $this->assertTrue($giveawayWinners->wasRefunded);
        $this->assertSame('Desc', $giveawayWinners->prizeDescription);
        $this->assertSame(99, $giveawayWinners->prizeStarCount);
    }
}

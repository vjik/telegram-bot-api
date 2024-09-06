<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\Chat;
use Vjik\TelegramBot\Api\Type\Giveaway;

final class GiveawayTest extends TestCase
{
    public function testBase(): void
    {
        $chat = new Chat(1, 'private');
        $date = new DateTimeImmutable();
        $giveaway = new Giveaway([$chat], $date, 3);

        $this->assertSame([$chat], $giveaway->chats);
        $this->assertSame($date, $giveaway->winnersSelectionDate);
        $this->assertSame(3, $giveaway->winnerCount);
        $this->assertNull($giveaway->onlyNewMembers);
        $this->assertNull($giveaway->hasPublicWinners);
        $this->assertNull($giveaway->prizeDescription);
        $this->assertNull($giveaway->countryCodes);
        $this->assertNull($giveaway->premiumSubscriptionMonthCount);
        $this->assertNull($giveaway->prizeStarCount);
    }

    public function testFromTelegramResult(): void
    {
        $giveaway = (new ObjectFactory())->create(
            [
            'chats' => [
                ['id' => 1, 'type' => 'private'],
            ],
            'winners_selection_date' => 1234567890,
            'winner_count' => 3,
            'only_new_members' => true,
            'has_public_winners' => true,
            'prize_description' => 'prize',
            'country_codes' => ['RU'],
                'prize_star_count' => 19,
            'premium_subscription_month_count' => 7,
            ],
            null,
            Giveaway::class,
        );

        $this->assertCount(1, $giveaway->chats);
        $this->assertInstanceOf(Chat::class, $giveaway->chats[0]);
        $this->assertSame(1, $giveaway->chats[0]->id);
        $this->assertSame('private', $giveaway->chats[0]->type);

        $this->assertSame(1234567890, $giveaway->winnersSelectionDate->getTimestamp());
        $this->assertSame(3, $giveaway->winnerCount);
        $this->assertTrue($giveaway->onlyNewMembers);
        $this->assertTrue($giveaway->hasPublicWinners);
        $this->assertSame('prize', $giveaway->prizeDescription);
        $this->assertSame(['RU'], $giveaway->countryCodes);
        $this->assertSame(7, $giveaway->premiumSubscriptionMonthCount);
        $this->assertSame(19, $giveaway->prizeStarCount);
    }
}

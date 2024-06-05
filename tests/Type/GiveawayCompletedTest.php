<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\GiveawayCompleted;
use Vjik\TelegramBot\Api\Type\Message;

final class GiveawayCompletedTest extends TestCase
{
    public function testBase(): void
    {
        $giveawayCompleted = new GiveawayCompleted(3);

        $this->assertSame(3, $giveawayCompleted->winnerCount);
        $this->assertNull($giveawayCompleted->unclaimedPrizeCount);
        $this->assertNull($giveawayCompleted->giveawayMessage);
    }

    public function testFromTelegramResult(): void
    {
        $giveawayCompleted = GiveawayCompleted::fromTelegramResult([
            'winner_count' => 3,
            'unclaimed_prize_count' => 2,
            'giveaway_message' => [
                'message_id' => 123,
                'date' => 1717501903,
                'chat' => [
                    'id' => 23,
                    'type' => 'private',
                ],
            ],
        ]);

        $this->assertSame(3, $giveawayCompleted->winnerCount);
        $this->assertSame(2, $giveawayCompleted->unclaimedPrizeCount);

        $this->assertInstanceOf(Message::class, $giveawayCompleted->giveawayMessage);
        $this->assertSame(123, $giveawayCompleted->giveawayMessage->messageId);
    }
}

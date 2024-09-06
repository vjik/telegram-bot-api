<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\ChatBoostSourceGiveaway;
use Vjik\TelegramBot\Api\Type\User;

final class ChatBoostSourceGiveawayTest extends TestCase
{
    public function testBase(): void
    {
        $source = new ChatBoostSourceGiveaway(12);

        $this->assertSame('giveaway', $source->getSource());
        $this->assertNull($source->getUser());
        $this->assertSame(12, $source->giveawayMessageId);
        $this->assertNull($source->user);
        $this->assertNull($source->isUnclaimed);
        $this->assertNull($source->prizeStarCount);
    }

    public function testFromTelegramResult(): void
    {
        $source = (new ObjectFactory())->create(
            [
                'source' => 'giveaway',
                'giveaway_message_id' => 12,
                'user' => [
                    'id' => 7,
                    'is_bot' => false,
                    'first_name' => 'Sergei',
                ],
                'prize_star_count' => 19,
                'is_unclaimed' => true,
            ],
            null,
            ChatBoostSourceGiveaway::class,
        );

        $this->assertSame(12, $source->giveawayMessageId);

        $this->assertInstanceOf(User::class, $source->user);
        $this->assertSame(7, $source->user->id);

        $this->assertTrue($source->isUnclaimed);
        $this->assertSame(19, $source->prizeStarCount);
    }
}

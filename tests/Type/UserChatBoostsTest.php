<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\ChatBoost;
use Vjik\TelegramBot\Api\Type\ChatBoostSourcePremium;
use Vjik\TelegramBot\Api\Type\User;
use Vjik\TelegramBot\Api\Type\UserChatBoosts;

final class UserChatBoostsTest extends TestCase
{
    public function testBase(): void
    {
        $chatBoost = new ChatBoost(
            'b1',
            new DateTimeImmutable(),
            new DateTimeImmutable(),
            new ChatBoostSourcePremium(new User(1, false, 'Sergei')),
        );
        $type = new UserChatBoosts([$chatBoost]);

        $this->assertSame([$chatBoost], $type->boosts);
    }

    public function testFromTelegramResult(): void
    {
        $type = UserChatBoosts::fromTelegramResult([
            'boosts' => [
                [
                    'boost_id' => 'b1',
                    'add_date' => 1619040000,
                    'expiration_date' => 1619040001,
                    'source' => [
                        'source' => 'premium',
                        'user' => [
                            'id' => 1,
                            'is_bot' => false,
                            'first_name' => 'Sergei',
                        ],
                    ],
                ],
            ],
        ]);

        $this->assertCount(1, $type->boosts);
        $this->assertSame('b1', $type->boosts[0]->boostId);
    }
}

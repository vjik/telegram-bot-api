<?php

declare(strict_types=1);

namespace Type;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\ChatBoost;
use Vjik\TelegramBot\Api\Type\ChatBoostSourcePremium;
use Vjik\TelegramBot\Api\Type\User;

final class ChatBoostTest extends TestCase
{
    public function testBase(): void
    {
        $addDate = new DateTimeImmutable();
        $expirationDate = new DateTimeImmutable();
        $chatBoostSource = new ChatBoostSourcePremium(new User(1, false, 'Sergei'));
        $chatBoost = new ChatBoost('b1', $addDate, $expirationDate, $chatBoostSource);

        $this->assertSame('b1', $chatBoost->boostId);
        $this->assertSame($addDate, $chatBoost->addDate);
        $this->assertSame($expirationDate, $chatBoost->expirationDate);
        $this->assertSame($chatBoostSource, $chatBoost->source);
    }

    public function testFromTelegramResult(): void
    {
        $chatBoost = ChatBoost::fromTelegramResult([
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
        ]);

        $this->assertSame('b1', $chatBoost->boostId);
        $this->assertEquals(new DateTimeImmutable('@1619040000'), $chatBoost->addDate);
        $this->assertEquals(new DateTimeImmutable('@1619040001'), $chatBoost->expirationDate);

        $this->assertInstanceOf(ChatBoostSourcePremium::class, $chatBoost->source);
        $this->assertSame(1, $chatBoost->source->user->id);
        $this->assertFalse($chatBoost->source->user->isBot);
        $this->assertSame('Sergei', $chatBoost->source->user->firstName);
    }
}

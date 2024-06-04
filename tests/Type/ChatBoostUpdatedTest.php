<?php

declare(strict_types=1);

namespace Type;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\Chat;
use Vjik\TelegramBot\Api\Type\ChatBoost;
use Vjik\TelegramBot\Api\Type\ChatBoostSourcePremium;
use Vjik\TelegramBot\Api\Type\ChatBoostUpdated;
use Vjik\TelegramBot\Api\Type\User;

final class ChatBoostUpdatedTest extends TestCase
{
    public function testBase(): void
    {
        $chat = new Chat(1, 'private');
        $chatBoost = new ChatBoost(
            'b1',
            new DateTimeImmutable(),
            new DateTimeImmutable(),
            new ChatBoostSourcePremium(
                new User(123, false, 'John'),
            ),
        );
        $chatBoostUpdated = new ChatBoostUpdated($chat, $chatBoost);

        $this->assertSame($chat, $chatBoostUpdated->chat);
        $this->assertSame($chatBoost, $chatBoostUpdated->boost);
    }

    public function testFromTelegramResult(): void
    {
        $chatBoostUpdated = ChatBoostUpdated::fromTelegramResult([
            'chat' => [
                'id' => 1,
                'type' => 'private',
            ],
            'boost' => [
                'boost_id' => 'b1',
                'add_date' => 1630000000,
                'expiration_date' => 1630000001,
                'source' => [
                    'source' => 'premium',
                    'user' => [
                        'id' => 123,
                        'is_bot' => false,
                        'first_name' => 'John',
                    ],
                ],
            ],
        ]);

        $this->assertSame(1, $chatBoostUpdated->chat->id);
        $this->assertSame('private', $chatBoostUpdated->chat->type);

        $this->assertSame('b1', $chatBoostUpdated->boost->boostId);
        $this->assertSame(1630000000, $chatBoostUpdated->boost->addDate->getTimestamp());
        $this->assertSame(1630000001, $chatBoostUpdated->boost->expirationDate->getTimestamp());
        $this->assertInstanceOf(ChatBoostSourcePremium::class, $chatBoostUpdated->boost->source);
        $this->assertSame(123, $chatBoostUpdated->boost->source->user->id);
    }
}

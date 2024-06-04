<?php

declare(strict_types=1);

namespace Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\ChatBoostSourcePremium;
use Vjik\TelegramBot\Api\Type\User;

final class ChatBoostSourcePremiumTest extends TestCase
{
    public function testBase(): void
    {
        $user = new User(123, false, 'John');
        $source = new ChatBoostSourcePremium($user);

        $this->assertSame('premium', $source->getSource());
        $this->assertSame($user, $source->getUser());
        $this->assertSame($user, $source->user);
    }

    public function testFromTelegramResult(): void
    {
        $source = ChatBoostSourcePremium::fromTelegramResult([
            'source' => 'premium',
            'user' => [
                'id' => 123,
                'is_bot' => false,
                'first_name' => 'John',
            ],
        ]);

        $this->assertSame(123, $source->user->id);
    }
}

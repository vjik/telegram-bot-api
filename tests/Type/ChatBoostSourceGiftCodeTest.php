<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\ChatBoostSourceGiftCode;
use Vjik\TelegramBot\Api\Type\User;

final class ChatBoostSourceGiftCodeTest extends TestCase
{
    public function testBase(): void
    {
        $user = new User(12, false, 'Sergei');
        $source = new ChatBoostSourceGiftCode($user);


        $this->assertSame('gift_code', $source->getSource());
        $this->assertSame($user, $source->getUser());
        $this->assertSame($user, $source->user);
    }

    public function testFromTelegramResult(): void
    {
        $source = ChatBoostSourceGiftCode::fromTelegramResult([
            'source' => 'gift_code',
            'user' => [
                'id' => 12,
                'is_bot' => false,
                'first_name' => 'Sergei',
            ],
        ]);

        $this->assertSame(12, $source->user->id);
    }
}

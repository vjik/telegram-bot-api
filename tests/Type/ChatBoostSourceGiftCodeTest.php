<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\ChatBoostSourceGiftCode;
use Vjik\TelegramBot\Api\Type\User;

use function PHPUnit\Framework\assertSame;

final class ChatBoostSourceGiftCodeTest extends TestCase
{
    public function testBase(): void
    {
        $user = new User(12, false, 'Sergei');
        $source = new ChatBoostSourceGiftCode($user);


        assertSame('gift_code', $source->getSource());
        assertSame($user, $source->getUser());
        assertSame($user, $source->user);
    }

    public function testFromTelegramResult(): void
    {
        $source = (new ObjectFactory())->create([
            'source' => 'gift_code',
            'user' => [
                'id' => 12,
                'is_bot' => false,
                'first_name' => 'Sergei',
            ],
        ], null, ChatBoostSourceGiftCode::class);

        assertSame(12, $source->user->id);
    }
}

<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\ChatBoostSourcePremium;
use Vjik\TelegramBot\Api\Type\User;

use function PHPUnit\Framework\assertSame;

final class ChatBoostSourcePremiumTest extends TestCase
{
    public function testBase(): void
    {
        $user = new User(123, false, 'John');
        $source = new ChatBoostSourcePremium($user);

        assertSame('premium', $source->getSource());
        assertSame($user, $source->getUser());
        assertSame($user, $source->user);
    }

    public function testFromTelegramResult(): void
    {
        $source = (new ObjectFactory())->create([
            'source' => 'premium',
            'user' => [
                'id' => 123,
                'is_bot' => false,
                'first_name' => 'John',
            ],
        ], null, ChatBoostSourcePremium::class);

        assertSame(123, $source->user->id);
    }
}

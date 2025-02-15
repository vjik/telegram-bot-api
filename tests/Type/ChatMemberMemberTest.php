<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\ChatMemberMember;
use Vjik\TelegramBot\Api\Type\User;

use function PHPUnit\Framework\assertSame;

final class ChatMemberMemberTest extends TestCase
{
    public function testBase(): void
    {
        $user = new User(123, false, 'John');
        $member = new ChatMemberMember($user);

        assertSame('member', $member->getStatus());
        assertSame($user, $member->getUser());
        assertSame($user, $member->user);
    }

    public function testFromTelegramResult(): void
    {
        $member = (new ObjectFactory())->create([
            'user' => [
                'id' => 123,
                'is_bot' => false,
                'first_name' => 'John',
            ],
        ], null, ChatMemberMember::class);

        assertSame(123, $member->user->id);
    }

    public function testFromTelegramResultFull(): void
    {
        $member = (new ObjectFactory())->create(
            [
                'user' => [
                    'id' => 123,
                    'is_bot' => false,
                    'first_name' => 'John',
                ],
                'until_date' => 1724317996,
            ],
            null,
            ChatMemberMember::class,
        );

        assertSame(123, $member->user->id);
        assertSame(1724317996, $member->untilDate?->getTimestamp());
    }
}

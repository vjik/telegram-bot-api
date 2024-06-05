<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\ChatMemberBanned;
use Vjik\TelegramBot\Api\Type\User;

final class ChatMemberBannedTest extends TestCase
{
    public function testBase(): void
    {
        $user = new User(123, false, 'John');
        $member = new ChatMemberBanned($user, false);

        $this->assertSame('kicked', $member->getStatus());
        $this->assertSame($user, $member->getUser());
        $this->assertSame($user, $member->user);
        $this->assertFalse($member->untilDate);
    }

    public function testFromTelegramResult(): void
    {
        $member = ChatMemberBanned::fromTelegramResult([
            'user' => [
                'id' => 123,
                'is_bot' => false,
                'first_name' => 'John',
            ],
            'until_date' => 123456779,
        ]);

        $this->assertSame(123, $member->user->id);
        $this->assertEquals(new DateTimeImmutable('@123456779'), $member->untilDate);
    }

    public function testFromTelegramResultWithZeroUntilDate(): void
    {
        $member = ChatMemberBanned::fromTelegramResult([
            'user' => [
                'id' => 123,
                'is_bot' => false,
                'first_name' => 'John',
            ],
            'until_date' => 0,
        ]);

        $this->assertSame(123, $member->user->id);
        $this->assertFalse($member->untilDate);
    }
}

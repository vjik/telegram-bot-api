<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\ChatMemberOwner;
use Vjik\TelegramBot\Api\Type\User;

final class ChatMemberOwnerTest extends TestCase
{
    public function testBase(): void
    {
        $user = new User(123, false, 'John');
        $member = new ChatMemberOwner($user, true);

        $this->assertSame('creator', $member->getStatus());
        $this->assertSame($user, $member->getUser());
        $this->assertSame($user, $member->user);
        $this->assertTrue($member->isAnonymous);
        $this->assertNull($member->customTitle);
    }

    public function testFromTelegramResult(): void
    {
        $member = ChatMemberOwner::fromTelegramResult([
            'user' => [
                'id' => 123,
                'is_bot' => false,
                'first_name' => 'John',
            ],
            'is_anonymous' => true,
            'custom_title' => 'Custom title',
        ]);

        $this->assertSame(123, $member->user->id);
        $this->assertTrue($member->isAnonymous);
        $this->assertSame('Custom title', $member->customTitle);
    }
}

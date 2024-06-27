<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\ChatInviteLink;
use Vjik\TelegramBot\Api\Type\User;

final class ChatInviteLinkTest extends TestCase
{
    public function testBase(): void
    {
        $user = new User(1, false, 'Mike');
        $chatInviteLink = new ChatInviteLink('https://t.me/joinchat/x1', $user, true, false, false);

        $this->assertSame('https://t.me/joinchat/x1', $chatInviteLink->inviteLink);
        $this->assertSame($user, $chatInviteLink->creator);
        $this->assertTrue($chatInviteLink->createsJoinRequest);
        $this->assertFalse($chatInviteLink->isPrimary);
        $this->assertFalse($chatInviteLink->isRevoked);
        $this->assertNull($chatInviteLink->name);
        $this->assertNull($chatInviteLink->expireDate);
        $this->assertNull($chatInviteLink->memberLimit);
        $this->assertNull($chatInviteLink->pendingJoinRequestCount);
    }

    public function testFromTelegramResult(): void
    {
        $result = [
            'invite_link' => 'https://t.me/joinchat/x1',
            'creator' => [
                'id' => 1,
                'is_bot' => false,
                'first_name' => 'Mike',
            ],
            'creates_join_request' => true,
            'is_primary' => false,
            'is_revoked' => false,
            'name' => 'Test',
            'expire_date' => 1631840400,
            'member_limit' => 100,
            'pending_join_request_count' => 10,
        ];

        $chatInviteLink = ChatInviteLink::fromTelegramResult($result);

        $this->assertSame('https://t.me/joinchat/x1', $chatInviteLink->inviteLink);
        $this->assertInstanceOf(User::class, $chatInviteLink->creator);
        $this->assertTrue($chatInviteLink->createsJoinRequest);
        $this->assertFalse($chatInviteLink->isPrimary);
        $this->assertFalse($chatInviteLink->isRevoked);
        $this->assertSame('Test', $chatInviteLink->name);
        $this->assertSame(1631840400, $chatInviteLink->expireDate?->getTimestamp());
        $this->assertSame(100, $chatInviteLink->memberLimit);
        $this->assertSame(10, $chatInviteLink->pendingJoinRequestCount);
    }
}

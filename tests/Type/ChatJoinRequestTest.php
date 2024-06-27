<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\Chat;
use Vjik\TelegramBot\Api\Type\ChatInviteLink;
use Vjik\TelegramBot\Api\Type\ChatJoinRequest;
use Vjik\TelegramBot\Api\Type\User;

final class ChatJoinRequestTest extends TestCase
{
    public function testBase(): void
    {
        $chat = new Chat(1, 'private');
        $user = new User(1, false, 'Mike');
        $date = new DateTimeImmutable();
        $chatJoinRequest = new ChatJoinRequest($chat, $user, 12, $date);

        $this->assertSame($chat, $chatJoinRequest->chat);
        $this->assertSame($user, $chatJoinRequest->from);
        $this->assertSame(12, $chatJoinRequest->userChatId);
        $this->assertSame($date, $chatJoinRequest->date);
        $this->assertNull($chatJoinRequest->bio);
        $this->assertNull($chatJoinRequest->inviteLink);
    }

    public function testFromTelegramResult(): void
    {
        $result = [
            'chat' => [
                'id' => 1,
                'type' => 'private',
            ],
            'from' => [
                'id' => 2,
                'is_bot' => false,
                'first_name' => 'Mike',
            ],
            'user_chat_id' => 12,
            'date' => 1631840400,
            'bio' => 'Test',
            'invite_link' => [
                'invite_link' => 'https://t.me/joinchat/x1',
                'creator' => [
                    'id' => 1,
                    'is_bot' => false,
                    'first_name' => 'Mike',
                ],
                'creates_join_request' => true,
                'is_primary' => false,
                'is_revoked' => false,
            ],
        ];

        $chatJoinRequest = ChatJoinRequest::fromTelegramResult($result);

        $this->assertInstanceOf(Chat::class, $chatJoinRequest->chat);
        $this->assertSame(1, $chatJoinRequest->chat->id);

        $this->assertInstanceOf(User::class, $chatJoinRequest->from);
        $this->assertSame(2, $chatJoinRequest->from->id);

        $this->assertSame(12, $chatJoinRequest->userChatId);
        $this->assertSame(1631840400, $chatJoinRequest->date?->getTimestamp());
        $this->assertSame('Test', $chatJoinRequest->bio);

        $this->assertInstanceOf(ChatInviteLink::class, $chatJoinRequest->inviteLink);
        $this->assertSame('https://t.me/joinchat/x1', $chatJoinRequest->inviteLink->inviteLink);
    }
}

<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\Chat;
use Vjik\TelegramBot\Api\Type\ChatInviteLink;
use Vjik\TelegramBot\Api\Type\ChatMemberMember;
use Vjik\TelegramBot\Api\Type\ChatMemberUpdated;
use Vjik\TelegramBot\Api\Type\User;

final class ChatMemberUpdatedTest extends TestCase
{
    public function testBase(): void
    {
        $chat = new Chat(123, 'group');
        $user = new User(123, false, 'John');
        $date = new DateTimeImmutable();
        $oldChatMember = new ChatMemberMember($user);
        $newChatMember = new ChatMemberMember($user);
        $chatMemberUpdated = new ChatMemberUpdated($chat, $user, $date, $oldChatMember, $newChatMember);

        $this->assertSame($chat, $chatMemberUpdated->chat);
        $this->assertSame($user, $chatMemberUpdated->from);
        $this->assertSame($date, $chatMemberUpdated->date);
        $this->assertSame($oldChatMember, $chatMemberUpdated->oldChatMember);
        $this->assertSame($newChatMember, $chatMemberUpdated->newChatMember);
        $this->assertNull($chatMemberUpdated->inviteLink);
        $this->assertNull($chatMemberUpdated->viaJoinRequest);
        $this->assertNull($chatMemberUpdated->viaChatFolderInviteLink);
    }

    public function testFromTelegramResult(): void
    {
        $chatMemberUpdated = (new ObjectFactory())->create([
            'chat' => [
                'id' => 123,
                'type' => 'group',
            ],
            'from' => [
                'id' => 5,
                'is_bot' => false,
                'first_name' => 'John',
            ],
            'date' => 123456779,
            'old_chat_member' => [
                'user' => [
                    'id' => 7,
                    'is_bot' => false,
                    'first_name' => 'John',
                ],
                'status' => 'member',
            ],
            'new_chat_member' => [
                'user' => [
                    'id' => 8,
                    'is_bot' => false,
                    'first_name' => 'John',
                ],
                'status' => 'member',
            ],
            'invite_link' => [
                'invite_link' => 'https://t.me/joinchat/123',
                'creator' => [
                    'id' => 3,
                    'is_bot' => false,
                    'first_name' => 'Mike',
                ],
                'creates_join_request' => true,
                'is_primary' => true,
                'is_revoked' => false,
            ],
            'via_join_request' => true,
            'via_chat_folder_invite_link' => false,
        ], null, ChatMemberUpdated::class);

        $this->assertSame(123, $chatMemberUpdated->chat->id);
        $this->assertSame(5, $chatMemberUpdated->from->id);
        $this->assertEquals(new DateTimeImmutable('@123456779'), $chatMemberUpdated->date);
        $this->assertSame(7, $chatMemberUpdated->oldChatMember->user->id);
        $this->assertSame(8, $chatMemberUpdated->newChatMember->user->id);

        $this->assertInstanceOf(ChatInviteLink::class, $chatMemberUpdated->inviteLink);
        $this->assertSame('https://t.me/joinchat/123', $chatMemberUpdated->inviteLink->inviteLink);

        $this->assertTrue($chatMemberUpdated->viaJoinRequest);
        $this->assertFalse($chatMemberUpdated->viaChatFolderInviteLink);
    }
}

<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\ChatMemberAdministrator;
use Vjik\TelegramBot\Api\Type\User;

final class ChatMemberAdministratorTest extends TestCase
{
    public function testBase(): void
    {
        $user = new User(123, false, 'John');
        $member = new ChatMemberAdministrator(
            $user,
            true,
            false,
            false,
            true,
            true,
            true,
            true,
            true,
            false,
            true,
            true,
            true,
        );

        $this->assertSame('administrator', $member->getStatus());
        $this->assertSame($user, $member->getUser());
        $this->assertSame($user, $member->user);
        $this->assertTrue($member->canBeEdited);
        $this->assertFalse($member->isAnonymous);
        $this->assertFalse($member->canManageChat);
        $this->assertTrue($member->canDeleteMessages);
        $this->assertTrue($member->canManageVideoChats);
        $this->assertTrue($member->canRestrictMembers);
        $this->assertTrue($member->canPromoteMembers);
        $this->assertTrue($member->canChangeInfo);
        $this->assertFalse($member->canInviteUsers);
        $this->assertTrue($member->canPostStories);
        $this->assertTrue($member->canEditStories);
        $this->assertTrue($member->canDeleteStories);
        $this->assertNull($member->canPostMessages);
        $this->assertNull($member->canEditMessages);
        $this->assertNull($member->canPinMessages);
        $this->assertNull($member->canManageTopics);
        $this->assertNull($member->customTitle);
    }

    public function testFromTelegramResult(): void
    {
        $member = ChatMemberAdministrator::fromTelegramResult([
            'user' => [
                'id' => 123,
                'is_bot' => false,
                'first_name' => 'John',
            ],
            'can_be_edited' => true,
            'is_anonymous' => false,
            'can_manage_chat' => false,
            'can_delete_messages' => true,
            'can_manage_video_chats' => true,
            'can_restrict_members' => true,
            'can_promote_members' => true,
            'can_change_info' => true,
            'can_invite_users' => false,
            'can_post_stories' => true,
            'can_edit_stories' => true,
            'can_delete_stories' => true,
            'can_post_messages' => true,
            'can_edit_messages' => false,
            'can_pin_messages' => true,
            'can_manage_topics' => false,
            'custom_title' => 'Custom title',
        ]);

        $this->assertSame(123, $member->user->id);
        $this->assertTrue($member->canBeEdited);
        $this->assertFalse($member->isAnonymous);
        $this->assertFalse($member->canManageChat);
        $this->assertTrue($member->canDeleteMessages);
        $this->assertTrue($member->canManageVideoChats);
        $this->assertTrue($member->canRestrictMembers);
        $this->assertTrue($member->canPromoteMembers);
        $this->assertTrue($member->canChangeInfo);
        $this->assertFalse($member->canInviteUsers);
        $this->assertTrue($member->canPostStories);
        $this->assertTrue($member->canEditStories);
        $this->assertTrue($member->canDeleteStories);
        $this->assertTrue($member->canPostMessages);
        $this->assertFalse($member->canEditMessages);
        $this->assertTrue($member->canPinMessages);
        $this->assertFalse($member->canManageTopics);
        $this->assertSame('Custom title', $member->customTitle);
    }
}

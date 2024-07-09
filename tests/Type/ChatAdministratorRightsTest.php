<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\ChatAdministratorRights;

final class ChatAdministratorRightsTest extends TestCase
{
    public function testBase(): void
    {
        $rights = new ChatAdministratorRights(true, true, true, true, true, true, true, true, true, true, false);

        $this->assertTrue($rights->isAnonymous);
        $this->assertTrue($rights->canManageChat);
        $this->assertTrue($rights->canDeleteMessages);
        $this->assertTrue($rights->canManageVideoChats);
        $this->assertTrue($rights->canRestrictMembers);
        $this->assertTrue($rights->canPromoteMembers);
        $this->assertTrue($rights->canChangeInfo);
        $this->assertTrue($rights->canInviteUsers);
        $this->assertTrue($rights->canPostStories);
        $this->assertTrue($rights->canEditStories);
        $this->assertFalse($rights->canDeleteStories);
        $this->assertNull($rights->canPostMessages);
        $this->assertNull($rights->canEditMessages);
        $this->assertNull($rights->canPinMessages);
        $this->assertNull($rights->canManageTopics);

        $this->assertSame(
            [
                'is_anonymous' => true,
                'can_manage_chat' => true,
                'can_delete_messages' => true,
                'can_manage_video_chats' => true,
                'can_restrict_members' => true,
                'can_promote_members' => true,
                'can_change_info' => true,
                'can_invite_users' => true,
                'can_post_stories' => true,
                'can_edit_stories' => true,
                'can_delete_stories' => false,
            ],
            $rights->toRequestArray(),
        );
    }

    public function testFromTelegramResult(): void
    {
        $type = (new ObjectFactory())->create([
            'is_anonymous' => true,
            'can_manage_chat' => false,
            'can_delete_messages' => true,
            'can_manage_video_chats' => true,
            'can_restrict_members' => false,
            'can_promote_members' => true,
            'can_change_info' => true,
            'can_invite_users' => true,
            'can_post_stories' => true,
            'can_edit_stories' => true,
            'can_delete_stories' => false,
            'can_post_messages' => true,
            'can_edit_messages' => true,
            'can_pin_messages' => false,
            'can_manage_topics' => true,
        ], null, ChatAdministratorRights::class);

        $this->assertTrue($type->isAnonymous);
        $this->assertFalse($type->canManageChat);
        $this->assertTrue($type->canDeleteMessages);
        $this->assertTrue($type->canManageVideoChats);
        $this->assertFalse($type->canRestrictMembers);
        $this->assertTrue($type->canPromoteMembers);
        $this->assertTrue($type->canChangeInfo);
        $this->assertTrue($type->canInviteUsers);
        $this->assertTrue($type->canPostStories);
        $this->assertTrue($type->canEditStories);
        $this->assertFalse($type->canDeleteStories);
        $this->assertTrue($type->canPostMessages);
        $this->assertTrue($type->canEditMessages);
        $this->assertFalse($type->canPinMessages);
        $this->assertTrue($type->canManageTopics);
    }
}

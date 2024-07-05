<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\ChatPermissions;

final class ChatPermissionsTest extends TestCase
{
    public function testBase(): void
    {
        $chatPermissions = new ChatPermissions();

        $this->assertNull($chatPermissions->canSendMessages);
        $this->assertNull($chatPermissions->canSendAudios);
        $this->assertNull($chatPermissions->canSendDocuments);
        $this->assertNull($chatPermissions->canSendPhotos);
        $this->assertNull($chatPermissions->canSendVideos);
        $this->assertNull($chatPermissions->canSendVideoNotes);
        $this->assertNull($chatPermissions->canSendVoiceNotes);
        $this->assertNull($chatPermissions->canSendPolls);
        $this->assertNull($chatPermissions->canSendOtherMessages);
        $this->assertNull($chatPermissions->canAddWebPagePreviews);
        $this->assertNull($chatPermissions->canChangeInfo);
        $this->assertNull($chatPermissions->canInviteUsers);
        $this->assertNull($chatPermissions->canPinMessages);
        $this->assertNull($chatPermissions->canManageTopics);
        $this->assertSame([], $chatPermissions->toRequestArray());
    }

    public function testFull(): void
    {
        $chatPermissions = new ChatPermissions(
            true,
            true,
            false,
            false,
            false,
            true,
            true,
            false,
            true,
            true,
            false,
            false,
            true,
            true,
        );

        $this->assertSame(
            [
                'can_send_messages' => true,
                'can_send_audios' => true,
                'can_send_documents' => false,
                'can_send_photos' => false,
                'can_send_videos' => false,
                'can_send_video_notes' => true,
                'can_send_voice_notes' => true,
                'can_send_polls' => false,
                'can_send_other_messages' => true,
                'can_add_web_page_previews' => true,
                'can_change_info' => false,
                'can_invite_users' => false,
                'can_pin_messages' => true,
                'can_manage_topics' => true,
            ],
            $chatPermissions->toRequestArray(),
        );
    }

    public function testFromTelegramResult(): void
    {
        $chatPermissions = (new ObjectFactory())->create([
            'can_send_messages' => true,
            'can_send_audios' => false,
            'can_send_documents' => true,
            'can_send_photos' => false,
            'can_send_videos' => true,
            'can_send_video_notes' => true,
            'can_send_voice_notes' => true,
            'can_send_polls' => true,
            'can_send_other_messages' => true,
            'can_add_web_page_previews' => true,
            'can_change_info' => true,
            'can_invite_users' => true,
            'can_pin_messages' => true,
            'can_manage_topics' => true,
        ], null, ChatPermissions::class);

        $this->assertTrue($chatPermissions->canSendMessages);
        $this->assertFalse($chatPermissions->canSendAudios);
        $this->assertTrue($chatPermissions->canSendDocuments);
        $this->assertFalse($chatPermissions->canSendPhotos);
        $this->assertTrue($chatPermissions->canSendVideos);
        $this->assertTrue($chatPermissions->canSendVideoNotes);
        $this->assertTrue($chatPermissions->canSendVoiceNotes);
        $this->assertTrue($chatPermissions->canSendPolls);
        $this->assertTrue($chatPermissions->canSendOtherMessages);
        $this->assertTrue($chatPermissions->canAddWebPagePreviews);
        $this->assertTrue($chatPermissions->canChangeInfo);
        $this->assertTrue($chatPermissions->canInviteUsers);
        $this->assertTrue($chatPermissions->canPinMessages);
        $this->assertTrue($chatPermissions->canManageTopics);
    }
}

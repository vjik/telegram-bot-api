<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\ChatMemberRestricted;
use Vjik\TelegramBot\Api\Type\User;

final class ChatMemberRestrictedTest extends TestCase
{
    public function testBase(): void
    {
        $user = new User(123, false, 'John');
        $member = new ChatMemberRestricted(
            $user,
            true,
            false,
            true,
            false,
            false,
            true,
            true,
            true,
            true,
            true,
            true,
            true,
            true,
            true,
            true,
            false,
        );

        $this->assertSame('restricted', $member->getStatus());
        $this->assertSame($user, $member->getUser());
        $this->assertSame($user, $member->user);
        $this->assertTrue($member->isMember);
        $this->assertFalse($member->canSendMessages);
        $this->assertTrue($member->canSendAudios);
        $this->assertFalse($member->canSendDocuments);
        $this->assertFalse($member->canSendPhotos);
        $this->assertTrue($member->canSendVideos);
        $this->assertTrue($member->canSendVideoNotes);
        $this->assertTrue($member->canSendVoiceNotes);
        $this->assertTrue($member->canSendPolls);
        $this->assertTrue($member->canSendOtherMessages);
        $this->assertTrue($member->canAddWebPagePreviews);
        $this->assertTrue($member->canChangeInfo);
        $this->assertTrue($member->canInviteUsers);
        $this->assertTrue($member->canPinMessages);
        $this->assertTrue($member->canManageTopics);
        $this->assertFalse($member->untilDate);
    }

    public function testFromTelegramResult(): void
    {
        $member = (new ObjectFactory())->create([
            'user' => [
                'id' => 123,
                'is_bot' => false,
                'first_name' => 'John',
            ],
            'is_member' => true,
            'can_send_messages' => false,
            'can_send_audios' => true,
            'can_send_documents' => false,
            'can_send_photos' => false,
            'can_send_videos' => false,
            'can_send_video_notes' => true,
            'can_send_voice_notes' => true,
            'can_send_polls' => true,
            'can_send_other_messages' => true,
            'can_add_web_page_previews' => true,
            'can_change_info' => true,
            'can_invite_users' => true,
            'can_pin_messages' => true,
            'can_manage_topics' => true,
            'until_date' => 123456779,
        ], null, ChatMemberRestricted::class);

        $this->assertSame(123, $member->user->id);
        $this->assertTrue($member->isMember);
        $this->assertFalse($member->canSendMessages);
        $this->assertTrue($member->canSendAudios);
        $this->assertFalse($member->canSendDocuments);
        $this->assertFalse($member->canSendPhotos);
        $this->assertFalse($member->canSendVideos);
        $this->assertTrue($member->canSendVideoNotes);
        $this->assertTrue($member->canSendVoiceNotes);
        $this->assertTrue($member->canSendPolls);
        $this->assertTrue($member->canSendOtherMessages);
        $this->assertTrue($member->canAddWebPagePreviews);
        $this->assertTrue($member->canChangeInfo);
        $this->assertTrue($member->canInviteUsers);
        $this->assertTrue($member->canPinMessages);
        $this->assertTrue($member->canManageTopics);
        $this->assertEquals(new DateTimeImmutable('@123456779'), $member->untilDate);
    }

    public function testFromTelegramResultWithZeroUntilDate(): void
    {
        $member = (new ObjectFactory())->create([
            'user' => [
                'id' => 123,
                'is_bot' => false,
                'first_name' => 'John',
            ],
            'is_member' => true,
            'can_send_messages' => false,
            'can_send_audios' => true,
            'can_send_documents' => false,
            'can_send_photos' => false,
            'can_send_videos' => false,
            'can_send_video_notes' => true,
            'can_send_voice_notes' => true,
            'can_send_polls' => true,
            'can_send_other_messages' => true,
            'can_add_web_page_previews' => true,
            'can_change_info' => true,
            'can_invite_users' => true,
            'can_pin_messages' => true,
            'can_manage_topics' => true,
            'until_date' => 0,
        ], null, ChatMemberRestricted::class);

        $this->assertSame(123, $member->user->id);
        $this->assertTrue($member->isMember);
        $this->assertFalse($member->canSendMessages);
        $this->assertTrue($member->canSendAudios);
        $this->assertFalse($member->canSendDocuments);
        $this->assertFalse($member->canSendPhotos);
        $this->assertFalse($member->canSendVideos);
        $this->assertTrue($member->canSendVideoNotes);
        $this->assertTrue($member->canSendVoiceNotes);
        $this->assertTrue($member->canSendPolls);
        $this->assertTrue($member->canSendOtherMessages);
        $this->assertTrue($member->canAddWebPagePreviews);
        $this->assertTrue($member->canChangeInfo);
        $this->assertTrue($member->canInviteUsers);
        $this->assertTrue($member->canPinMessages);
        $this->assertTrue($member->canManageTopics);
        $this->assertFalse($member->untilDate);
    }
}

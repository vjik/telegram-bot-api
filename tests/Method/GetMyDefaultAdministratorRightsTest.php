<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\GetMyDefaultAdministratorRights;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;

final class GetMyDefaultAdministratorRightsTest extends TestCase
{
    public function testBase(): void
    {
        $method = new GetMyDefaultAdministratorRights();

        $this->assertSame(HttpMethod::GET, $method->getHttpMethod());
        $this->assertSame('getMyDefaultAdministratorRights', $method->getApiMethod());
        $this->assertSame([], $method->getData());
    }

    public function testFull(): void
    {
        $method = new GetMyDefaultAdministratorRights(true);

        $this->assertSame(
            [
                'for_channels' => true,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new GetMyDefaultAdministratorRights();

        $preparedResult = TestHelper::createSuccessStubApi([
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
        ])->send($method);

        $this->assertTrue($preparedResult->isAnonymous);
        $this->assertFalse($preparedResult->canManageChat);
        $this->assertTrue($preparedResult->canDeleteMessages);
        $this->assertTrue($preparedResult->canManageVideoChats);
        $this->assertFalse($preparedResult->canRestrictMembers);
        $this->assertTrue($preparedResult->canPromoteMembers);
        $this->assertTrue($preparedResult->canChangeInfo);
        $this->assertTrue($preparedResult->canInviteUsers);
        $this->assertTrue($preparedResult->canPostStories);
        $this->assertTrue($preparedResult->canEditStories);
        $this->assertFalse($preparedResult->canDeleteStories);
        $this->assertTrue($preparedResult->canPostMessages);
        $this->assertTrue($preparedResult->canEditMessages);
        $this->assertFalse($preparedResult->canPinMessages);
        $this->assertTrue($preparedResult->canManageTopics);
    }
}

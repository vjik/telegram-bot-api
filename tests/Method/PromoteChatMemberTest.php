<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\PromoteChatMember;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;

final class PromoteChatMemberTest extends TestCase
{
    public function testBase(): void
    {
        $method = new PromoteChatMember(1, 2);

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('promoteChatMember', $method->getApiMethod());
        $this->assertSame(
            [
                'chat_id' => 1,
                'user_id' => 2,
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $method = new PromoteChatMember(
            1,
            2,
            true,
            true,
            false,
            true,
            false,
            false,
            false,
            true,
            true,
            false,
            true,
            false,
            true,
            true,
            true,
        );

        $this->assertSame(
            [
                'chat_id' => 1,
                'user_id' => 2,
                'is_anonymous' => true,
                'can_manage_chat' => true,
                'can_delete_messages' => false,
                'can_manage_video_chats' => true,
                'can_restrict_members' => false,
                'can_promote_members' => false,
                'can_change_info' => false,
                'can_invite_users' => true,
                'can_post_stories' => true,
                'can_edit_stories' => false,
                'can_delete_stories' => true,
                'can_post_messages' => false,
                'can_edit_messages' => true,
                'can_pin_messages' => true,
                'can_manage_topics' => true,
            ],
            $method->getData()
        );
    }

    public function testPrepareResult(): void
    {
        $method = new PromoteChatMember(1, 2);

        $preparedResult = TestHelper::createSuccessStubApi(true)->send($method);

        $this->assertTrue($preparedResult);
    }
}

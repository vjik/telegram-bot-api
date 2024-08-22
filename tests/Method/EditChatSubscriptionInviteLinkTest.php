<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\EditChatSubscriptionInviteLink;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;

final class EditChatSubscriptionInviteLinkTest extends TestCase
{
    public function testBase(): void
    {
        $method = new EditChatSubscriptionInviteLink(1, 'https://t.me/+example');

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('editChatSubscriptionInviteLink', $method->getApiMethod());
        $this->assertSame(
            [
                'chat_id' => 1,
                'invite_link' => 'https://t.me/+example',
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $method = new EditChatSubscriptionInviteLink(1, 'https://t.me/+example', 'Hello');

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('editChatSubscriptionInviteLink', $method->getApiMethod());
        $this->assertSame(
            [
                'chat_id' => 1,
                'invite_link' => 'https://t.me/+example',
                'name' => 'Hello',
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new EditChatSubscriptionInviteLink(1, 'https://t.me/+example');

        $preparedResult = TestHelper::createSuccessStubApi([
            'invite_link' => 'https//t.me/+example',
            'creator' => [
                'id' => 23,
                'is_bot' => true,
                'first_name' => 'testBot',
            ],
            'creates_join_request' => true,
            'is_primary' => true,
            'is_revoked' => false,
        ])->send($method);

        $this->assertSame(23, $preparedResult->creator->id);
    }
}

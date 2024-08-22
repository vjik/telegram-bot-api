<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\CreateChatSubscriptionInviteLink;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;

final class CreateChatSubscriptionInviteLinkTest extends TestCase
{
    public function testBase(): void
    {
        $method = new CreateChatSubscriptionInviteLink(10, 20, 30);

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('createChatSubscriptionInviteLink', $method->getApiMethod());
        $this->assertSame(
            [
                'chat_id' => 10,
                'subscription_period' => 20,
                'subscription_price' => 30,
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $method = new CreateChatSubscriptionInviteLink(10, 20, 30, 'test');

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('createChatSubscriptionInviteLink', $method->getApiMethod());
        $this->assertSame(
            [
                'chat_id' => 10,
                'name' => 'test',
                'subscription_period' => 20,
                'subscription_price' => 30,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new CreateChatSubscriptionInviteLink(1, 2, 3);

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

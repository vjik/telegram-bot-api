<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\CreateChatInviteLink;
use Vjik\TelegramBot\Api\Request\HttpMethod;

final class CreateChatInviteLinkTest extends TestCase
{
    public function testBase(): void
    {
        $method = new CreateChatInviteLink(23);

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('createChatInviteLink', $method->getApiMethod());
        $this->assertSame(['chat_id' => 23], $method->getData());
    }

    public function testFull(): void
    {
        $date = new DateTimeImmutable();
        $method = new CreateChatInviteLink(1, 'hello', $date, 23, false);

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('createChatInviteLink', $method->getApiMethod());
        $this->assertSame(
            [
                'chat_id' => 1,
                'name' => 'hello',
                'expire_date' => $date->getTimestamp(),
                'member_limit' => 23,
                'creates_join_request' => false,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new CreateChatInviteLink(1);

        $preparedResult = $method->prepareResult([
            'invite_link' => 'https//t.me/+example',
            'creator' => [
                'id' => 23,
                'is_bot' => true,
                'first_name' => 'testBot',
            ],
            'creates_join_request' => true,
            'is_primary' => true,
            'is_revoked' => false,
        ]);

        $this->assertSame(23, $preparedResult->creator->id);
    }
}

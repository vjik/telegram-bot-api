<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\RestrictChatMember;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Type\ChatPermissions;

final class RestrictChatMemberTest extends TestCase
{
    public function testBase(): void
    {
        $permissions = new ChatPermissions();
        $method = new RestrictChatMember(1, 2, $permissions);

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('restrictChatMember', $method->getApiMethod());
        $this->assertSame(
            [
                'chat_id' => 1,
                'user_id' => 2,
                'permissions' => $permissions->toRequestArray(),
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $permissions = new ChatPermissions();
        $date = new DateTimeImmutable();
        $method = new RestrictChatMember(1, 2, $permissions, true, $date);

        $this->assertSame(
            [
                'chat_id' => 1,
                'user_id' => 2,
                'permissions' => $permissions->toRequestArray(),
                'use_independent_chat_permissions' => true,
                'until_date' => $date->getTimestamp(),
            ],
            $method->getData()
        );
    }

    public function testPrepareResult(): void
    {
        $method = new RestrictChatMember(1, 2, new ChatPermissions());

        $preparedResult = $method->prepareResult(true);

        $this->assertTrue($preparedResult);
    }
}

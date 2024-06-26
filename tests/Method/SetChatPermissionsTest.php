<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\SetChatPermissions;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Type\ChatPermissions;

final class SetChatPermissionsTest extends TestCase
{
    public function testBase(): void
    {
        $permissions = new ChatPermissions();
        $method = new SetChatPermissions(1, $permissions);

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('setChatPermissions', $method->getApiMethod());
        $this->assertSame(
            [
                'chat_id' => 1,
                'permissions' => $permissions->toRequestArray(),
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $permissions = new ChatPermissions();
        $method = new SetChatPermissions(1, $permissions, true);

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('setChatPermissions', $method->getApiMethod());
        $this->assertSame(
            [
                'chat_id' => 1,
                'permissions' => $permissions->toRequestArray(),
                'use_independent_chat_permissions' => true,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SetChatPermissions(1, new ChatPermissions());

        $preparedResult = $method->prepareResult(true);

        $this->assertTrue($preparedResult);
    }
}

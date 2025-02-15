<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\SetChatPermissions;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;
use Vjik\TelegramBot\Api\Type\ChatPermissions;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class SetChatPermissionsTest extends TestCase
{
    public function testBase(): void
    {
        $permissions = new ChatPermissions();
        $method = new SetChatPermissions(1, $permissions);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('setChatPermissions', $method->getApiMethod());
        assertSame(
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

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('setChatPermissions', $method->getApiMethod());
        assertSame(
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

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}

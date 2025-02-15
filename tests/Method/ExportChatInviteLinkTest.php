<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\ExportChatInviteLink;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;

final class ExportChatInviteLinkTest extends TestCase
{
    public function testBase(): void
    {
        $method = new ExportChatInviteLink(1);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('exportChatInviteLink', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 1,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new ExportChatInviteLink(1);

        $preparedResult = TestHelper::createSuccessStubApi('https://t.me/+example')->call($method);

        assertSame('https://t.me/+example', $preparedResult);
    }
}

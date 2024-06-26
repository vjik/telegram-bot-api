<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\ExportChatInviteLink;
use Vjik\TelegramBot\Api\Request\HttpMethod;

final class ExportChatInviteLinkTest extends TestCase
{
    public function testBase(): void
    {
        $method = new ExportChatInviteLink(1);

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('exportChatInviteLink', $method->getApiMethod());
        $this->assertSame(
            [
                'chat_id' => 1,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new ExportChatInviteLink(1);

        $preparedResult = $method->prepareResult('https://t.me/+example');

        $this->assertSame('https://t.me/+example', $preparedResult);
    }
}

<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\GetChat;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;

final class GetChatTest extends TestCase
{
    public function testBase(): void
    {
        $method = new GetChat(99);

        $this->assertSame(HttpMethod::GET, $method->getHttpMethod());
        $this->assertSame('getChat', $method->getApiMethod());
        $this->assertSame(['chat_id' => 99], $method->getData());
    }

    public function testPrepareResult(): void
    {
        $method = new GetChat(99);

        $preparedResult = TestHelper::createSuccessStubApi([
            'id' => 23,
            'type' => 'private',
            'accent_color_id' => 0x123456,
            'max_reaction_count' => 5,
        ])->call($method);

        $this->assertSame(23, $preparedResult->id);
    }
}

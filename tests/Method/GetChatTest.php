<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\GetChat;
use Vjik\TelegramBot\Api\Request\HttpMethod;

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

        $preparedResult = $method->prepareResult([
            'id' => 23,
            'type' => 'private',
            'accent_color_id' => 0x123456,
            'max_reaction_count' => 5,
        ]);

        $this->assertSame(23, $preparedResult->id);
    }
}

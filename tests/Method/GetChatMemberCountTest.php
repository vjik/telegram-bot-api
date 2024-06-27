<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\GetChatMemberCount;
use Vjik\TelegramBot\Api\Request\HttpMethod;

final class GetChatMemberCountTest extends TestCase
{
    public function testBase(): void
    {
        $method = new GetChatMemberCount(1);

        $this->assertSame(HttpMethod::GET, $method->getHttpMethod());
        $this->assertSame('getChatMemberCount', $method->getApiMethod());
        $this->assertSame(
            [
                'chat_id' => 1,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new GetChatMemberCount(1);

        $preparedResult = $method->prepareResult(23);

        $this->assertSame(23, $preparedResult);
    }
}

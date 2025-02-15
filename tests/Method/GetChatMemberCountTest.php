<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\GetChatMemberCount;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;

final class GetChatMemberCountTest extends TestCase
{
    public function testBase(): void
    {
        $method = new GetChatMemberCount(1);

        assertSame(HttpMethod::GET, $method->getHttpMethod());
        assertSame('getChatMemberCount', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 1,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new GetChatMemberCount(1);

        $preparedResult = TestHelper::createSuccessStubApi(23)->call($method);

        assertSame(23, $preparedResult);
    }
}

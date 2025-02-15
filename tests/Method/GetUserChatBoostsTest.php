<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\GetUserChatBoosts;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;

final class GetUserChatBoostsTest extends TestCase
{
    public function testBase(): void
    {
        $method = new GetUserChatBoosts(1, 2);

        assertSame(HttpMethod::GET, $method->getHttpMethod());
        assertSame('getUserChatBoosts', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 1,
                'user_id' => 2,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new GetUserChatBoosts(1, 2);

        $preparedResult = TestHelper::createSuccessStubApi([
            'boosts' => [],
        ])->call($method);

        assertSame([], $preparedResult->boosts);
    }
}

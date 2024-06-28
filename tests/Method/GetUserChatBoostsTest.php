<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\GetUserChatBoosts;
use Vjik\TelegramBot\Api\Request\HttpMethod;

final class GetUserChatBoostsTest extends TestCase
{
    public function testBase(): void
    {
        $method = new GetUserChatBoosts(1, 2);

        $this->assertSame(HttpMethod::GET, $method->getHttpMethod());
        $this->assertSame('getUserChatBoosts', $method->getApiMethod());
        $this->assertSame(
            [
                'chat_id' => 1,
                'user_id' => 2,
            ],
            $method->getData()
        );
    }

    public function testPrepareResult(): void
    {
        $method = new GetUserChatBoosts(1, 2);

        $preparedResult = $method->prepareResult([
            'boosts' => [],
        ]);

        $this->assertSame([], $preparedResult->boosts);
    }
}

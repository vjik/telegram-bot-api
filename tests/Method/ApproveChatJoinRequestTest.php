<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\ApproveChatJoinRequest;
use Vjik\TelegramBot\Api\Request\HttpMethod;

final class ApproveChatJoinRequestTest extends TestCase
{
    public function testBase(): void
    {
        $method = new ApproveChatJoinRequest(1, 2);

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('approveChatJoinRequest', $method->getApiMethod());
        $this->assertSame(
            [
                'chat_id' => 1,
                'user_id' => 2,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new ApproveChatJoinRequest(1, 2);

        $preparedResult = $method->prepareResult(true);

        $this->assertTrue($preparedResult);
    }
}

<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\UnbanChatMember;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;

final class UnbanChatMemberTest extends TestCase
{
    public function testBase(): void
    {
        $method = new UnbanChatMember(1, 2);

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('unbanChatMember', $method->getApiMethod());
        $this->assertSame(
            [
                'chat_id' => 1,
                'user_id' => 2,
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $method = new UnbanChatMember(1, 2, true);

        $this->assertSame(
            [
                'chat_id' => 1,
                'user_id' => 2,
                'only_if_banned' => true,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new UnbanChatMember(1, 2);

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        $this->assertTrue($preparedResult);
    }
}

<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\BanChatMember;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class BanChatMemberTest extends TestCase
{
    public function testBase(): void
    {
        $method = new BanChatMember(1, 2);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('banChatMember', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 1,
                'user_id' => 2,
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $date = new DateTimeImmutable();
        $method = new BanChatMember(1, 2, $date, true);

        assertSame(
            [
                'chat_id' => 1,
                'user_id' => 2,
                'until_date' => $date->getTimestamp(),
                'revoke_messages' => true,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new BanChatMember(1, 2);

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}

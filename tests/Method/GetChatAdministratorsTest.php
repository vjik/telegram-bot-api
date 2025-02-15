<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\GetChatAdministrators;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;
use Vjik\TelegramBot\Api\Type\ChatMemberMember;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class GetChatAdministratorsTest extends TestCase
{
    public function testBase(): void
    {
        $method = new GetChatAdministrators(1);

        assertSame(HttpMethod::GET, $method->getHttpMethod());
        assertSame('getChatAdministrators', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 1,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new GetChatAdministrators(1);

        $preparedResult = TestHelper::createSuccessStubApi([
            [
                'status' => 'member',
                'user' => ['id' => 23, 'is_bot' => false, 'first_name' => 'Mike'],
            ],
        ])->call($method);

        assertCount(1, $preparedResult);
        assertInstanceOf(ChatMemberMember::class, $preparedResult[0]);
        assertSame(23, $preparedResult[0]->user->id);
    }
}

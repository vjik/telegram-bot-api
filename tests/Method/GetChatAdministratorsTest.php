<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\GetChatAdministrators;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;
use Vjik\TelegramBot\Api\Type\ChatMemberMember;

final class GetChatAdministratorsTest extends TestCase
{
    public function testBase(): void
    {
        $method = new GetChatAdministrators(1);

        $this->assertSame(HttpMethod::GET, $method->getHttpMethod());
        $this->assertSame('getChatAdministrators', $method->getApiMethod());
        $this->assertSame(
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
        ])->send($method);

        $this->assertCount(1, $preparedResult);
        $this->assertInstanceOf(ChatMemberMember::class, $preparedResult[0]);
        $this->assertSame(23, $preparedResult[0]->user->id);
    }
}

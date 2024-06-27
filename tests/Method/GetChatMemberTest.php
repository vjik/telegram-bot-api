<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\GetChatMember;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Type\ChatMemberMember;

final class GetChatMemberTest extends TestCase
{
    public function testBase(): void
    {
        $method = new GetChatMember(1, 2);

        $this->assertSame(HttpMethod::GET, $method->getHttpMethod());
        $this->assertSame('getChatMember', $method->getApiMethod());
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
        $method = new GetChatMember(1, 2);

        $preparedResult = $method->prepareResult([
            'status' => 'member',
            'user' => ['id' => 23, 'is_bot' => false, 'first_name' => 'Mike'],
        ]);

        $this->assertInstanceOf(ChatMemberMember::class, $preparedResult);
        $this->assertSame(23, $preparedResult->user->id);
    }
}

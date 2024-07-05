<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\ForwardMessages;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;
use Vjik\TelegramBot\Api\Type\MessageId;

final class ForwardMessagesTest extends TestCase
{
    public function testBase(): void
    {
        $method = new ForwardMessages(1, 2, [3, 4]);

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('forwardMessages', $method->getApiMethod());
        $this->assertSame(
            [
                'chat_id' => 1,
                'from_chat_id' => 2,
                'message_ids' => [3, 4],
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $method = new ForwardMessages(1, 2, [3, 4], 5, true, false);

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('forwardMessages', $method->getApiMethod());
        $this->assertSame(
            [
                'chat_id' => 1,
                'message_thread_id' => 5,
                'from_chat_id' => 2,
                'message_ids' => [3, 4],
                'disable_notification' => true,
                'protect_content' => false,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new ForwardMessages(1, 2, [3, 4]);

        $preparedResult = TestHelper::createSuccessStubApi([
            [
                'message_id' => 7,
            ],
            [
                'message_id' => 8,
            ],
        ])->send($method);

        $this->assertCount(2, $preparedResult);
        $this->assertInstanceOf(MessageId::class, $preparedResult[0]);
        $this->assertInstanceOf(MessageId::class, $preparedResult[1]);
        $this->assertSame(7, $preparedResult[0]->messageId);
        $this->assertSame(8, $preparedResult[1]->messageId);
    }
}

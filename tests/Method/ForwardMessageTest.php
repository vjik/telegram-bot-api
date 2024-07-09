<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\ForwardMessage;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;

final class ForwardMessageTest extends TestCase
{
    public function testBase(): void
    {
        $method = new ForwardMessage(1, 2, 3);

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('forwardMessage', $method->getApiMethod());
        $this->assertSame(
            [
                'chat_id' => 1,
                'from_chat_id' => 2,
                'message_id' => 3,
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $method = new ForwardMessage(
            1,
            2,
            3,
            4,
            true,
            false,
        );

        $this->assertSame(
            [
                'chat_id' => 1,
                'message_thread_id' => 4,
                'from_chat_id' => 2,
                'disable_notification' => true,
                'protect_content' => false,
                'message_id' => 3,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new ForwardMessage(1, 2, 3);

        $preparedResult = TestHelper::createSuccessStubApi([
            'message_id' => 7,
            'date' => 1620000000,
            'chat' => [
                'id' => 1,
                'type' => 'private',
            ],
        ])->send($method);

        $this->assertSame(7, $preparedResult->messageId);
    }
}

<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\CloseForumTopic;
use Vjik\TelegramBot\Api\Request\HttpMethod;

final class CloseForumTopicTest extends TestCase
{
    public function testBase(): void
    {
        $method = new CloseForumTopic(1, 2);

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('closeForumTopic', $method->getApiMethod());
        $this->assertSame(
            [
                'chat_id' => 1,
                'message_thread_id' => 2,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new CloseForumTopic(1, 2);

        $preparedResult = $method->prepareResult(true);

        $this->assertTrue($preparedResult);
    }
}

<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\CreateForumTopic;
use Vjik\TelegramBot\Api\Request\HttpMethod;

final class CreateForumTopicTest extends TestCase
{
    public function testBase(): void
    {
        $method = new CreateForumTopic(1, 'test');

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('createForumTopic', $method->getApiMethod());
        $this->assertSame(
            [
                'chat_id' => 1,
                'name' => 'test',
            ],
            $method->getData()
        );
    }

    public function testFull(): void
    {
        $method = new CreateForumTopic(1, 'test', 0x6FB9F0, '2135123');

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('createForumTopic', $method->getApiMethod());
        $this->assertSame(
            [
                'chat_id' => 1,
                'name' => 'test',
                'icon_color' => 0x6FB9F0,
                'icon_custom_emoji_id' => '2135123',
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new CreateForumTopic(1, 'test');

        $preparedResult = $method->prepareResult([
            'message_thread_id' => 19,
            'name' => 'test',
            'icon_color' => 0x00FF00,
            'icon_custom_emoji_id' => '2351346235143',
        ]);

        $this->assertSame(19, $preparedResult->messageThreadId);
    }
}

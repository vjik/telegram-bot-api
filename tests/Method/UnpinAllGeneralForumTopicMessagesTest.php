<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\UnpinAllGeneralForumTopicMessages;
use Vjik\TelegramBot\Api\Request\HttpMethod;

final class UnpinAllGeneralForumTopicMessagesTest extends TestCase
{
    public function testBase(): void
    {
        $method = new UnpinAllGeneralForumTopicMessages(1);

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('unpinAllGeneralForumTopicMessages', $method->getApiMethod());
        $this->assertSame(
            [
                'chat_id' => 1,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new UnpinAllGeneralForumTopicMessages(1);

        $preparedResult = $method->prepareResult(true);

        $this->assertTrue($preparedResult);
    }
}

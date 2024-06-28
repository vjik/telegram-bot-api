<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\HideGeneralForumTopic;
use Vjik\TelegramBot\Api\Request\HttpMethod;

final class HideGeneralForumTopicTest extends TestCase
{
    public function testBase(): void
    {
        $method = new HideGeneralForumTopic(1);

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('hideGeneralForumTopic', $method->getApiMethod());
        $this->assertSame(
            [
                'chat_id' => 1,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new HideGeneralForumTopic(2);

        $preparedResult = $method->prepareResult(true);

        $this->assertTrue($preparedResult);
    }
}

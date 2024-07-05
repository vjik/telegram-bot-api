<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\CloseGeneralForumTopic;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;

final class CloseGeneralForumTopicTest extends TestCase
{
    public function testBase(): void
    {
        $method = new CloseGeneralForumTopic(1);

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('closeGeneralForumTopic', $method->getApiMethod());
        $this->assertSame(
            [
                'chat_id' => 1,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new CloseGeneralForumTopic(2);

        $preparedResult = TestHelper::createSuccessStubApi(true)->send($method);

        $this->assertTrue($preparedResult);
    }
}

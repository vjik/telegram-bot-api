<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\EditGeneralForumTopic;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class EditGeneralForumTopicTest extends TestCase
{
    public function testBase(): void
    {
        $method = new EditGeneralForumTopic(1, 'test');

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('editGeneralForumTopic', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 1,
                'name' => 'test',
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new EditGeneralForumTopic(1, 'test');

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}

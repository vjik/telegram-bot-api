<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\SetChatTitle;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class SetChatTitleTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SetChatTitle(1, 'test');

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('setChatTitle', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 1,
                'title' => 'test',
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SetChatTitle(1, 'test');

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}

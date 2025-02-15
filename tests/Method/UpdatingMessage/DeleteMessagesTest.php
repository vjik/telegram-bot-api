<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method\UpdatingMessage;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\UpdatingMessage\DeleteMessages;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class DeleteMessagesTest extends TestCase
{
    public function testBase(): void
    {
        $method = new DeleteMessages(1, [2, 3]);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('deleteMessages', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 1,
                'message_ids' => [2, 3],
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new DeleteMessages(1, [2, 3]);

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}

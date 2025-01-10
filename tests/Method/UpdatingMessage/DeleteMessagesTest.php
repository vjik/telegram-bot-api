<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method\UpdatingMessage;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\UpdatingMessage\DeleteMessages;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;

final class DeleteMessagesTest extends TestCase
{
    public function testBase(): void
    {
        $method = new DeleteMessages(1, [2, 3]);

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('deleteMessages', $method->getApiMethod());
        $this->assertSame(
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

        $this->assertTrue($preparedResult);
    }
}

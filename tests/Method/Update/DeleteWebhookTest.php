<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method\Update;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Method\Update\DeleteWebhook;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class DeleteWebhookTest extends TestCase
{
    public function testBase(): void
    {
        $method = new DeleteWebhook();

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('deleteWebhook', $method->getApiMethod());
        assertSame([], $method->getData());
    }

    public function testFull(): void
    {
        $method = new DeleteWebhook(true);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('deleteWebhook', $method->getApiMethod());
        assertSame(
            [
                'drop_pending_updates' => true,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new DeleteWebhook();

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}

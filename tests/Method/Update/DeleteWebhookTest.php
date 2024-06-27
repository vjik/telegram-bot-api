<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method\Update;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Method\Update\DeleteWebhook;

final class DeleteWebhookTest extends TestCase
{
    public function testBase(): void
    {
        $method = new DeleteWebhook();

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('deleteWebhook', $method->getApiMethod());
        $this->assertSame([], $method->getData());
    }

    public function testFull(): void
    {
        $method = new DeleteWebhook(true);

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('deleteWebhook', $method->getApiMethod());
        $this->assertSame(
            [
                'drop_pending_updates' => true,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new DeleteWebhook();

        $preparedResult = $method->prepareResult(true);

        $this->assertTrue($preparedResult);
    }
}

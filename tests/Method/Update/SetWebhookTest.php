<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method\Update;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Method\Update\SetWebhook;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;

final class SetWebhookTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SetWebhook('https://example.com/hook');

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('setWebhook', $method->getApiMethod());
        $this->assertSame(
            [
                'url' => 'https://example.com/hook',
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $method = new SetWebhook(
            'https://example.com/hook',
            '127.0.0.1',
            12,
            ['update1', 'update2'],
            true,
            'asdg23y',
        );

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('setWebhook', $method->getApiMethod());
        $this->assertSame(
            [
                'url' => 'https://example.com/hook',
                'ip_address' => '127.0.0.1',
                'max_connections' => 12,
                'allowed_updates' => ['update1', 'update2'],
                'drop_pending_updates' => true,
                'secret_token' => 'asdg23y',
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SetWebhook('https://example.com/hook');

        $preparedResult = TestHelper::createSuccessStubApi(true)->send($method);

        $this->assertTrue($preparedResult);
    }
}

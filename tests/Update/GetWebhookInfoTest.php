<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Update;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Update\GetWebhookInfo;

final class GetWebhookInfoTest extends TestCase
{
    public function testBase(): void
    {
        $method = new GetWebhookInfo();

        $this->assertSame(HttpMethod::GET, $method->getHttpMethod());
        $this->assertSame('getWebhookInfo', $method->getApiMethod());
        $this->assertSame([], $method->getData());
    }

    public function testPrepareResult(): void
    {
        $method = new GetWebhookInfo();

        $preparedResult = $method->prepareResult([
            'url' => 'https://example.com/',
            'has_custom_certificate' => true,
            'pending_update_count' => 12,
        ]);

        $this->assertSame('https://example.com/', $preparedResult->url);
    }
}

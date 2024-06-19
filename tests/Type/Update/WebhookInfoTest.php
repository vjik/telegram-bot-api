<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Update;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\Update\WebhookInfo;

final class WebhookInfoTest extends TestCase
{
    public function testBase(): void
    {
        $info = new WebhookInfo('https://example.com/', false, 12);

        $this->assertSame('https://example.com/', $info->url);
        $this->assertFalse($info->hasCustomCertificate);
        $this->assertSame(12, $info->pendingUpdateCount);
        $this->assertNull($info->ipAddress);
        $this->assertNull($info->lastErrorDate);
        $this->assertNull($info->lastErrorMessage);
        $this->assertNull($info->lastSynchronizationErrorDate);
        $this->assertNull($info->maxConnections);
        $this->assertNull($info->allowedUpdates);
    }

    public function testFromTelegramResult(): void
    {
        $info = WebhookInfo::fromTelegramResult([
            'url' => 'https://example.com/',
            'has_custom_certificate' => true,
            'pending_update_count' => 12,
            'ip_address' => '127.0.0.1',
            'last_error_date' => 1717501903,
            'last_error_message' => 'test error',
            'last_synchronization_error_date' => 1717501904,
            'max_connections' => 15,
            'allowed_updates' => ['update1', 'update2'],
        ]);

        $this->assertSame('https://example.com/', $info->url);
        $this->assertTrue($info->hasCustomCertificate);
        $this->assertSame(12, $info->pendingUpdateCount);
        $this->assertSame('127.0.0.1', $info->ipAddress);
        $this->assertEquals(new DateTimeImmutable('@1717501903'), $info->lastErrorDate);
        $this->assertSame('test error', $info->lastErrorMessage);
        $this->assertEquals(new DateTimeImmutable('@1717501904'), $info->lastSynchronizationErrorDate);
        $this->assertSame(15, $info->maxConnections);
        $this->assertSame(['update1', 'update2'], $info->allowedUpdates);
    }
}

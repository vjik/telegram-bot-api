<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\WebAppInfo;

final class WebAppInfoTest extends TestCase
{
    public function testBase(): void
    {
        $webAppInfo = new WebAppInfo('https://example.com');

        $this->assertSame('https://example.com', $webAppInfo->url);

        $this->assertSame(
            [
                'url' => 'https://example.com',
            ],
            $webAppInfo->toRequestArray(),
        );
    }

    public function testFromTelegramResult(): void
    {
        $webAppInfo = WebAppInfo::fromTelegramResult([
            'url' => 'https://example.com',
        ]);

        $this->assertSame('https://example.com', $webAppInfo->url);
    }
}

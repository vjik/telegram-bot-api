<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\WebAppInfo;

use function PHPUnit\Framework\assertSame;

final class WebAppInfoTest extends TestCase
{
    public function testBase(): void
    {
        $webAppInfo = new WebAppInfo('https://example.com');

        assertSame('https://example.com', $webAppInfo->url);

        assertSame(
            [
                'url' => 'https://example.com',
            ],
            $webAppInfo->toRequestArray(),
        );
    }

    public function testFromTelegramResult(): void
    {
        $webAppInfo = (new ObjectFactory())->create([
            'url' => 'https://example.com',
        ], null, WebAppInfo::class);

        assertSame('https://example.com', $webAppInfo->url);
    }
}

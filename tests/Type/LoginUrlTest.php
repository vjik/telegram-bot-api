<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\LoginUrl;

final class LoginUrlTest extends TestCase
{
    public function testBase(): void
    {
        $loginUrl = new LoginUrl('https://example.com/');

        $this->assertSame('https://example.com/', $loginUrl->url);
        $this->assertNull($loginUrl->forwardText);
        $this->assertNull($loginUrl->botUsername);
        $this->assertNull($loginUrl->requestWriteAccess);

        $this->assertSame(
            [
                'url' => 'https://example.com/',
            ],
            $loginUrl->toRequestArray(),
        );
    }

    public function testFilled(): void
    {
        $loginUrl = new LoginUrl('https://example.com/', 'ft', 'bun', false);

        $this->assertSame('https://example.com/', $loginUrl->url);
        $this->assertSame('ft', $loginUrl->forwardText);
        $this->assertSame('bun', $loginUrl->botUsername);
        $this->assertFalse($loginUrl->requestWriteAccess);

        $this->assertSame(
            [
                'url' => 'https://example.com/',
                'forward_text' => 'ft',
                'bot_username' => 'bun',
                'request_write_access' => false,
            ],
            $loginUrl->toRequestArray(),
        );
    }

    public function testFromTelegramResult(): void
    {
        $loginUrl = (new ObjectFactory())->create([
            'url' => 'https://example.com/',
            'forward_text' => 'ft',
            'bot_username' => 'bun',
            'request_write_access' => false,
        ], null, LoginUrl::class);

        $this->assertSame('https://example.com/', $loginUrl->url);
        $this->assertSame('ft', $loginUrl->forwardText);
        $this->assertSame('bun', $loginUrl->botUsername);
        $this->assertFalse($loginUrl->requestWriteAccess);
    }
}

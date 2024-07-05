<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\WriteAccessAllowed;

final class WriteAccessAllowedTest extends TestCase
{
    public function testBase(): void
    {
        $writeAccessAllowed = new WriteAccessAllowed();

        $this->assertNull($writeAccessAllowed->fromRequest);
        $this->assertNull($writeAccessAllowed->webAppName);
        $this->assertNull($writeAccessAllowed->fromAttachmentMenu);
    }

    public function testFromTelegramResult(): void
    {
        $writeAccessAllowed = (new ObjectFactory())->create([
            'from_request' => true,
            'web_app_name' => 'test',
            'from_attachment_menu' => false,
        ], null, WriteAccessAllowed::class);

        $this->assertTrue($writeAccessAllowed->fromRequest);
        $this->assertSame('test', $writeAccessAllowed->webAppName);
        $this->assertFalse($writeAccessAllowed->fromAttachmentMenu);
    }
}

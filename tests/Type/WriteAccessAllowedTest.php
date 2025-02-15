<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\WriteAccessAllowed;

use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class WriteAccessAllowedTest extends TestCase
{
    public function testBase(): void
    {
        $writeAccessAllowed = new WriteAccessAllowed();

        assertNull($writeAccessAllowed->fromRequest);
        assertNull($writeAccessAllowed->webAppName);
        assertNull($writeAccessAllowed->fromAttachmentMenu);
    }

    public function testFromTelegramResult(): void
    {
        $writeAccessAllowed = (new ObjectFactory())->create([
            'from_request' => true,
            'web_app_name' => 'test',
            'from_attachment_menu' => false,
        ], null, WriteAccessAllowed::class);

        assertTrue($writeAccessAllowed->fromRequest);
        assertSame('test', $writeAccessAllowed->webAppName);
        assertFalse($writeAccessAllowed->fromAttachmentMenu);
    }
}

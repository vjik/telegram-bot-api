<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Inline;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\Inline\SentWebAppMessage;

final class SentWebAppMessageTest extends TestCase
{
    public function testBase(): void
    {
        $type = new SentWebAppMessage('id1');

        $this->assertSame('id1', $type->inlineMessageId);
    }

    public function testFromTelegramResult(): void
    {
        $type = SentWebAppMessage::fromTelegramResult([
            'inline_message_id' => 'id1',
        ]);

        $this->assertSame('id1', $type->inlineMessageId);
    }
}

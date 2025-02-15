<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\MessageId;

use function PHPUnit\Framework\assertSame;

final class MessageIdTest extends TestCase
{
    public function testBase(): void
    {
        $type = new MessageId(23);

        assertSame(23, $type->messageId);
    }

    public function testFromTelegramResult(): void
    {
        $type = (new ObjectFactory())->create(['message_id' => 23], null, MessageId::class);

        assertSame(23, $type->messageId);
    }
}

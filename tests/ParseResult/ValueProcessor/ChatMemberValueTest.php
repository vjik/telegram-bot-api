<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\ParseResult\ValueProcessor;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ChatMemberValue;

final class ChatMemberValueTest extends TestCase
{
    public function testUnknown(): void
    {
        $objectFactory = new ObjectFactory();
        $processor = new ChatMemberValue();

        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Unknown chat member status.');
        $processor->process(['status' => 'test'], null, $objectFactory);
    }
}

<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\ParseResult\ValueProcessor;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\MessageOriginValue;

final class MessageOriginValueTest extends TestCase
{
    public function testUnknown(): void
    {
        $objectFactory = new ObjectFactory();
        $processor = new MessageOriginValue();

        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Unknown message origin type.');
        $processor->process(['type' => 'test'], null, $objectFactory);
    }
}

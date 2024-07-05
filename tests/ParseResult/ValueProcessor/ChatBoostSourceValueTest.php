<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\ParseResult\ValueProcessor;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ChatBoostSourceValue;

final class ChatBoostSourceValueTest extends TestCase
{
    public function testUnknown(): void
    {
        $objectFactory = new ObjectFactory();
        $processor = new ChatBoostSourceValue();

        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Unknown chat boost source.');
        $processor->process(['source' => 'test'], null, $objectFactory);
    }
}

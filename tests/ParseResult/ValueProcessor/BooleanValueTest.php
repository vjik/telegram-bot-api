<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\ParseResult\ValueProcessor;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\InvalidTypeOfValueInResultException;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\BooleanValue;

final class BooleanValueTest extends TestCase
{
    public function testUnknown(): void
    {
        $objectFactory = new ObjectFactory();
        $processor = new BooleanValue();

        $this->expectException(InvalidTypeOfValueInResultException::class);
        $this->expectExceptionMessage('Invalid type of value. Expected type is "boolean", but got "string".');
        $processor->process('test', null, $objectFactory);
    }
}

<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\ParseResult\ValueProcessor;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\InvalidTypeOfValueInResultException;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\IntegerValue;

final class IntegerValueTest extends TestCase
{
    public function testInvalidType(): void
    {
        $objectFactory = new ObjectFactory();
        $processor = new IntegerValue();

        $this->expectException(InvalidTypeOfValueInResultException::class);
        $this->expectExceptionMessage('Invalid type of value. Expected type is "integer", but got "string".');
        $processor->process('test', null, $objectFactory);
    }
}

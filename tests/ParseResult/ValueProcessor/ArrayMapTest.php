<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\ParseResult\ValueProcessor;

use phpDocumentor\Reflection\PseudoTypes\StringValue;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\InvalidTypeOfValueInResultException;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ArrayMap;

final class ArrayMapTest extends TestCase
{
    public function testInvalidType(): void
    {
        $objectFactory = new ObjectFactory();
        $processor = new ArrayMap(StringValue::class);

        $this->expectException(InvalidTypeOfValueInResultException::class);
        $this->expectExceptionMessage('Invalid type of value. Expected type is "array", but got "string".');
        $processor->process('test', null, $objectFactory);
    }
}

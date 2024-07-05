<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\ParseResult\ValueProcessor;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\InvalidTypeOfValueInResultException;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ArrayOfArraysOfObjectsValue;
use Vjik\TelegramBot\Api\Type\BotName;

final class ArrayOfArraysOfObjectsValueTest extends TestCase
{
    public function testNotArray(): void
    {
        $processor = new ArrayOfArraysOfObjectsValue(BotName::class);
        $objectFactory = new ObjectFactory();

        $this->expectException(InvalidTypeOfValueInResultException::class);
        $this->expectExceptionMessage('Invalid type of value. Expected type is "array[]", but got "string".');
        $processor->process('test', null, $objectFactory);
    }

    public function testNotArrayItems(): void
    {
        $processor = new ArrayOfArraysOfObjectsValue(BotName::class);
        $objectFactory = new ObjectFactory();

        $this->expectException(InvalidTypeOfValueInResultException::class);
        $this->expectExceptionMessage('Invalid type of value. Expected type is "array[]", but got "string".');
        $processor->process(['test'], null, $objectFactory);
    }
}

<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\ParseResult\ValueProcessor;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\InvalidTypeOfValueInResultException;
use Vjik\TelegramBot\Api\ParseResult\NotFoundKeyInResultException;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\MessageOriginValue;

final class InterfaceValueTest extends TestCase
{
    public function testInvalidType(): void
    {
        $objectFactory = new ObjectFactory();
        $processor = new MessageOriginValue();

        $this->expectException(InvalidTypeOfValueInResultException::class);
        $this->expectExceptionMessage('Invalid type of value. Expected type is "array", but got "string".');
        $processor->process('test', null, $objectFactory);
    }

    public function testWithoutTypeKey(): void
    {
        $objectFactory = new ObjectFactory();
        $processor = new MessageOriginValue();

        $this->expectException(NotFoundKeyInResultException::class);
        $this->expectExceptionMessage('Not found key "type" in result object.');
        $processor->process([], null, $objectFactory);
    }

    public function testInvalidTypeOfTypeKey(): void
    {
        $objectFactory = new ObjectFactory();
        $processor = new MessageOriginValue();

        $this->expectException(InvalidTypeOfValueInResultException::class);
        $this->expectExceptionMessage(
            'Invalid type of value for key "type". Expected type is "string", but got "int".'
        );
        $processor->process(['type' => 23], null, $objectFactory);
    }
}

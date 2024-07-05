<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\ParseResult\ValueProcessor;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\InvalidTypeOfValueInResultException;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\TrueValue;

final class TrueValueTest extends TestCase
{
    public function testInvalidType(): void
    {
        $objectFactory = new ObjectFactory();
        $processor = new TrueValue();

        $this->expectException(InvalidTypeOfValueInResultException::class);
        $this->expectExceptionMessage('Invalid type of value. Expected type is "true", but got "string".');
        $processor->process('test', null, $objectFactory);
    }
}

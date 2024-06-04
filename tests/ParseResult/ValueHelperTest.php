<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\ParseResult;

use PHPUnit\Framework\TestCase;
use Throwable;
use Vjik\TelegramBot\Api\ParseResult\InvalidTypeOfValueInResultException;
use Vjik\TelegramBot\Api\ParseResult\NotFoundKeyInResultException;
use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

final class ValueHelperTest extends TestCase
{
    public function testAssertArrayResult(): void
    {
        ValueHelper::assertArrayResult([]);

        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Expected result as array. Got string.');
        ValueHelper::assertArrayResult('hello');
    }

    public function testGetString(): void
    {
        $result = [
            'key' => 'hello',
            'number' => 7,
        ];

        $this->assertSame('hello', ValueHelper::getString($result, 'key'));

        $exception = null;
        try {
            ValueHelper::getString($result, 'unknown');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(NotFoundKeyInResultException::class, $exception);
        $this->assertSame('Not found key "unknown" in result object.', $exception->getMessage());

        $exception = null;
        try {
            ValueHelper::getString($result, 'number');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(InvalidTypeOfValueInResultException::class, $exception);
        $this->assertSame(
            'Invalid type of value for key "number". Expected type is "string", but got "int".',
            $exception->getMessage()
        );
    }

    public function testGetStringOrNull(): void
    {
        $result = [
            'key' => 'hello',
            'number' => 7,
        ];

        $this->assertSame('hello', ValueHelper::getStringOrNull($result, 'key'));
        $this->assertNull(ValueHelper::getStringOrNull($result, 'unknown'));

        $exception = null;
        try {
            ValueHelper::getStringOrNull($result, 'number');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(InvalidTypeOfValueInResultException::class, $exception);
        $this->assertSame(
            'Invalid type of value for key "number". Expected type is "string", but got "int".',
            $exception->getMessage()
        );
    }

    public function testGetBoolean(): void
    {
        $result = [
            'key' => true,
            'number' => 7,
        ];

        $this->assertTrue(ValueHelper::getBoolean($result, 'key'));

        $exception = null;
        try {
            ValueHelper::getBoolean($result, 'unknown');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(NotFoundKeyInResultException::class, $exception);
        $this->assertSame('Not found key "unknown" in result object.', $exception->getMessage());

        $exception = null;
        try {
            ValueHelper::getBoolean($result, 'number');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(InvalidTypeOfValueInResultException::class, $exception);
        $this->assertSame(
            'Invalid type of value for key "number". Expected type is "boolean", but got "int".',
            $exception->getMessage()
        );
    }

    public function testGetBooleanOrNull(): void
    {
        $result = [
            'key' => true,
            'number' => 7,
        ];

        $this->assertTrue(ValueHelper::getBooleanOrNull($result, 'key'));
        $this->assertNull(ValueHelper::getBooleanOrNull($result, 'unknown'));

        $exception = null;
        try {
            ValueHelper::getBooleanOrNull($result, 'number');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(InvalidTypeOfValueInResultException::class, $exception);
        $this->assertSame(
            'Invalid type of value for key "number". Expected type is "boolean", but got "int".',
            $exception->getMessage()
        );
    }
}

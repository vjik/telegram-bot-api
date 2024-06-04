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

    public function testGetTrueOrNull(): void
    {
        $result = [
            'key' => true,
            'false' => false,
            'number' => 7,
        ];

        $this->assertTrue(ValueHelper::getTrueOrNull($result, 'key'));
        $this->assertNull(ValueHelper::getTrueOrNull($result, 'unknown'));

        $exception = null;
        try {
            ValueHelper::getTrueOrNull($result, 'false');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(InvalidTypeOfValueInResultException::class, $exception);
        $this->assertSame(
            'Invalid type of value for key "false". Expected type is "true", but got "bool".',
            $exception->getMessage()
        );

        $exception = null;
        try {
            ValueHelper::getTrueOrNull($result, 'number');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(InvalidTypeOfValueInResultException::class, $exception);
        $this->assertSame(
            'Invalid type of value for key "number". Expected type is "true", but got "int".',
            $exception->getMessage()
        );
    }

    public function testGetInteger(): void
    {
        $result = [
            'key' => 7,
            'float' => 7.7,
            'string' => 'hello',
        ];

        $this->assertSame(7, ValueHelper::getInteger($result, 'key'));

        $exception = null;
        try {
            ValueHelper::getInteger($result, 'unknown');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(NotFoundKeyInResultException::class, $exception);
        $this->assertSame('Not found key "unknown" in result object.', $exception->getMessage());

        $exception = null;
        try {
            ValueHelper::getInteger($result, 'float');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(InvalidTypeOfValueInResultException::class, $exception);
        $this->assertSame(
            'Invalid type of value for key "float". Expected type is "integer", but got "float".',
            $exception->getMessage()
        );

        $exception = null;
        try {
            ValueHelper::getInteger($result, 'string');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(InvalidTypeOfValueInResultException::class, $exception);
        $this->assertSame(
            'Invalid type of value for key "string". Expected type is "integer", but got "string".',
            $exception->getMessage()
        );
    }

    public function testGetIntegerOrNull(): void
    {
        $result = [
            'key' => 7,
            'string' => 'hello',
        ];

        $this->assertSame(7, ValueHelper::getIntegerOrNull($result, 'key'));
        $this->assertNull(ValueHelper::getIntegerOrNull($result, 'unknown'));

        $exception = null;
        try {
            ValueHelper::getIntegerOrNull($result, 'string');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(InvalidTypeOfValueInResultException::class, $exception);
        $this->assertSame(
            'Invalid type of value for key "string". Expected type is "integer", but got "string".',
            $exception->getMessage()
        );
    }

    public function testGetFloat(): void
    {
        $result = [
            'key' => 7.7,
            'integer' => 7,
            'string' => 'hello',
        ];

        $this->assertSame(7.7, ValueHelper::getFloat($result, 'key'));
        $this->assertSame(7.0, ValueHelper::getFloat($result, 'integer'));

        $exception = null;
        try {
            ValueHelper::getFloat($result, 'unknown');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(NotFoundKeyInResultException::class, $exception);
        $this->assertSame('Not found key "unknown" in result object.', $exception->getMessage());

        $exception = null;
        try {
            ValueHelper::getFloat($result, 'string');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(InvalidTypeOfValueInResultException::class, $exception);
        $this->assertSame(
            'Invalid type of value for key "string". Expected type is "float", but got "string".',
            $exception->getMessage()
        );
    }

    public function testGetFloatOrNull(): void
    {
        $result = [
            'key' => 7.7,
            'integer' => 7,
            'string' => 'hello',
        ];

        $this->assertSame(7.7, ValueHelper::getFloatOrNull($result, 'key'));
        $this->assertSame(7.0, ValueHelper::getFloatOrNull($result, 'integer'));
        $this->assertNull(ValueHelper::getFloatOrNull($result, 'unknown'));

        $exception = null;
        try {
            ValueHelper::getFloatOrNull($result, 'string');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(InvalidTypeOfValueInResultException::class, $exception);
        $this->assertSame(
            'Invalid type of value for key "string". Expected type is "float", but got "string".',
            $exception->getMessage()
        );
    }

    public function testGetDateTimeImmutable(): void
    {
        $result = [
            'key' => 1717498851,
            'string' => 'hello',
        ];

        $this->assertSame(1717498851, ValueHelper::getDateTimeImmutable($result, 'key')->getTimestamp());

        $exception = null;
        try {
            ValueHelper::getDateTimeImmutable($result, 'unknown');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(NotFoundKeyInResultException::class, $exception);
        $this->assertSame('Not found key "unknown" in result object.', $exception->getMessage());

        $exception = null;
        try {
            ValueHelper::getDateTimeImmutable($result, 'string');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(InvalidTypeOfValueInResultException::class, $exception);
        $this->assertSame(
            'Invalid type of value for key "string". Expected type is "integer", but got "string".',
            $exception->getMessage()
        );
    }

    public function testGetDateTimeImmutableOrNull(): void
    {
        $result = [
            'key' => 1717498851,
            'string' => 'hello',
        ];

        $this->assertSame(1717498851, ValueHelper::getDateTimeImmutableOrNull($result, 'key')?->getTimestamp());
        $this->assertNull(ValueHelper::getDateTimeImmutableOrNull($result, 'unknown'));

        $exception = null;
        try {
            ValueHelper::getDateTimeImmutableOrNull($result, 'string');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(InvalidTypeOfValueInResultException::class, $exception);
        $this->assertSame(
            'Invalid type of value for key "string". Expected type is "integer", but got "string".',
            $exception->getMessage()
        );
    }

    public function testGetArray(): void
    {
        $result = [
            'key' => ['hello'],
            'number' => 7,
        ];

        $this->assertSame(['hello'], ValueHelper::getArray($result, 'key'));

        $exception = null;
        try {
            ValueHelper::getArray($result, 'unknown');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(NotFoundKeyInResultException::class, $exception);
        $this->assertSame('Not found key "unknown" in result object.', $exception->getMessage());

        $exception = null;
        try {
            ValueHelper::getArray($result, 'number');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(InvalidTypeOfValueInResultException::class, $exception);
        $this->assertSame(
            'Invalid type of value for key "number". Expected type is "array", but got "int".',
            $exception->getMessage()
        );
    }

    public function testGetArrayOrNull(): void
    {
        $result = [
            'key' => ['hello'],
            'number' => 7,
        ];

        $this->assertSame(['hello'], ValueHelper::getArrayOrNull($result, 'key'));
        $this->assertNull(ValueHelper::getArrayOrNull($result, 'unknown'));

        $exception = null;
        try {
            ValueHelper::getArrayOrNull($result, 'number');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(InvalidTypeOfValueInResultException::class, $exception);
        $this->assertSame(
            'Invalid type of value for key "number". Expected type is "array", but got "int".',
            $exception->getMessage()
        );
    }
}

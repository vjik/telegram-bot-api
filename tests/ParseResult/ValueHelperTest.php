<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\ParseResult;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Throwable;
use Vjik\TelegramBot\Api\ParseResult\InvalidTypeOfValueInResultException;
use Vjik\TelegramBot\Api\ParseResult\NotFoundKeyInResultException;
use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;
use Vjik\TelegramBot\Api\Type\BusinessOpeningHoursInterval;
use Vjik\TelegramBot\Api\Type\ChatBoost;
use Vjik\TelegramBot\Api\Type\ChatBoostSourcePremium;
use Vjik\TelegramBot\Api\Type\InlineKeyboardButton;
use Vjik\TelegramBot\Api\Type\MessageEntity;
use Vjik\TelegramBot\Api\Type\PaidMediaPhoto;
use Vjik\TelegramBot\Api\Type\PaidMediaPreview;
use Vjik\TelegramBot\Api\Type\Passport\EncryptedPassportElement;
use Vjik\TelegramBot\Api\Type\Passport\PassportFile;
use Vjik\TelegramBot\Api\Type\Payment\StarTransaction;
use Vjik\TelegramBot\Api\Type\PhotoSize;
use Vjik\TelegramBot\Api\Type\ReactionCount;
use Vjik\TelegramBot\Api\Type\ReactionTypeCustomEmoji;
use Vjik\TelegramBot\Api\Type\ReactionTypeEmoji;
use Vjik\TelegramBot\Api\Type\SharedUser;
use Vjik\TelegramBot\Api\Type\Sticker\Sticker;
use Vjik\TelegramBot\Api\Type\User;

final class ValueHelperTest extends TestCase
{
    public function testAssertArrayResult(): void
    {
        ValueHelper::assertArrayResult([]);

        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Expected result as array. Got "string".');
        ValueHelper::assertArrayResult('hello');
    }

    public function testAssertStringResult(): void
    {
        ValueHelper::assertStringResult('hello');

        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Expected result as string. Got "array".');
        ValueHelper::assertStringResult([]);
    }

    public function testAssertIntegerResult(): void
    {
        ValueHelper::assertIntegerResult(25);

        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Expected result as integer. Got "array".');
        ValueHelper::assertIntegerResult([]);
    }

    public function testAssertTrueResult(): void
    {
        ValueHelper::assertTrueResult(true);

        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Expected result as true. Got "array".');
        ValueHelper::assertTrueResult([]);
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

    public function testGetArrayOfArrays(): void
    {
        $result = [
            'key' => [['hello'], []],
            'array-of-not-arrays' => [1, 2],
            'number' => 7,
        ];

        $this->assertSame([['hello'], []], ValueHelper::getArrayOfArrays($result, 'key'));

        $exception = null;
        try {
            ValueHelper::getArrayOfArrays($result, 'unknown');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(NotFoundKeyInResultException::class, $exception);
        $this->assertSame('Not found key "unknown" in result object.', $exception->getMessage());

        $exception = null;
        try {
            ValueHelper::getArrayOfArrays($result, 'number');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(InvalidTypeOfValueInResultException::class, $exception);
        $this->assertSame(
            'Invalid type of value for key "number". Expected type is "array", but got "int".',
            $exception->getMessage()
        );

        $exception = null;
        try {
            ValueHelper::getArrayOfArrays($result, 'array-of-not-arrays');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(InvalidTypeOfValueInResultException::class, $exception);
        $this->assertSame(
            'Invalid type of value for key "array-of-not-arrays". Expected type is "array[]", but got "array".',
            $exception->getMessage()
        );
    }

    public function testGetArrayOfStringsOrNull(): void
    {
        $result = [
            'key' => ['hello', 'test'],
            'array-of-not-strings' => [1, 2],
            'number' => 7,
        ];

        $this->assertSame(['hello', 'test'], ValueHelper::getArrayOfStringsOrNull($result, 'key'));
        $this->assertNull(ValueHelper::getArrayOfStringsOrNull($result, 'unknown'));

        $exception = null;
        try {
            ValueHelper::getArrayOfStringsOrNull($result, 'number');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(InvalidTypeOfValueInResultException::class, $exception);
        $this->assertSame(
            'Invalid type of value for key "number". Expected type is "string[]", but got "int".',
            $exception->getMessage()
        );

        $exception = null;
        try {
            ValueHelper::getArrayOfStringsOrNull($result, 'array-of-not-strings');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(InvalidTypeOfValueInResultException::class, $exception);
        $this->assertSame(
            'Invalid type of value for key "array-of-not-strings". Expected type is "string[]", but got "array".',
            $exception->getMessage()
        );
    }

    public function testGetArrayOfIntegers(): void
    {
        $result = [
            'key' => [1, 2],
            'array-of-strings' => ['a', 'b'],
            'number' => 7,
        ];

        $this->assertSame([1, 2], ValueHelper::getArrayOfIntegers($result, 'key'));

        $exception = null;
        try {
            ValueHelper::getArrayOfIntegers($result, 'unknown');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(NotFoundKeyInResultException::class, $exception);
        $this->assertSame('Not found key "unknown" in result object.', $exception->getMessage());

        $exception = null;
        try {
            ValueHelper::getArrayOfIntegers($result, 'number');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(InvalidTypeOfValueInResultException::class, $exception);
        $this->assertSame(
            'Invalid type of value for key "number". Expected type is "array", but got "int".',
            $exception->getMessage()
        );

        $exception = null;
        try {
            ValueHelper::getArrayOfIntegers($result, 'array-of-strings');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(InvalidTypeOfValueInResultException::class, $exception);
        $this->assertSame(
            'Invalid type of value for key "array-of-strings". Expected type is "int[]", but got "array".',
            $exception->getMessage()
        );
    }

    public function testGetArrayOfMessageEntitiesOrNull(): void
    {
        $result = [
            'key' => [
                ['type' => 'bold', 'offset' => 0, 'length' => 5],
                ['type' => 'italic', 'offset' => 6, 'length' => 5],
            ],
            'array-of-ints' => [1, 2],
            'number' => 7,
        ];

        $this->assertEquals(
            [new MessageEntity('bold', 0, 5), new MessageEntity('italic', 6, 5)],
            ValueHelper::getArrayOfMessageEntitiesOrNull($result, 'key')
        );
        $this->assertNull(ValueHelper::getArrayOfMessageEntitiesOrNull($result, 'unknown'));

        $exception = null;
        try {
            ValueHelper::getArrayOfMessageEntitiesOrNull($result, 'number');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(InvalidTypeOfValueInResultException::class, $exception);
        $this->assertSame(
            'Invalid type of value for key "number". Expected type is "array", but got "int".',
            $exception->getMessage()
        );

        $exception = null;
        try {
            ValueHelper::getArrayOfMessageEntitiesOrNull($result, 'array-of-ints');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(TelegramParseResultException::class, $exception);
        $this->assertSame(
            'Expected result as array. Got "int".',
            $exception->getMessage()
        );
    }

    public function testGetArrayOfPhotoSizes(): void
    {
        $result = [
            'key' => [
                ['file_id' => '1', 'file_unique_id' => 'x1', 'width' => 10, 'height' => 10],
                ['file_id' => '2', 'file_unique_id' => 'x2', 'width' => 15, 'height' => 17],
            ],
            'array-of-ints' => [1, 2],
            'number' => 7,
        ];

        $this->assertEquals(
            [new PhotoSize('1', 'x1', 10, 10), new PhotoSize('2', 'x2', 15, 17)],
            ValueHelper::getArrayOfPhotoSizes($result, 'key')
        );

        $exception = null;
        try {
            ValueHelper::getArrayOfPhotoSizes($result, 'unknown');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(NotFoundKeyInResultException::class, $exception);
        $this->assertSame('Not found key "unknown" in result object.', $exception->getMessage());

        $exception = null;
        try {
            ValueHelper::getArrayOfPhotoSizes($result, 'number');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(InvalidTypeOfValueInResultException::class, $exception);
        $this->assertSame(
            'Invalid type of value for key "number". Expected type is "array", but got "int".',
            $exception->getMessage()
        );

        $exception = null;
        try {
            ValueHelper::getArrayOfPhotoSizes($result, 'array-of-ints');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(TelegramParseResultException::class, $exception);
        $this->assertSame(
            'Expected result as array. Got "int".',
            $exception->getMessage()
        );
    }

    public function testGetArrayOfPaidMedia(): void
    {
        $result = [
            'key' => [
                ['type' => 'photo', 'photo' => []],
                ['type' => 'preview', 'width' => 100, 'height' => 100, 'duration' => 23],
            ],
            'array-of-ints' => [1, 2],
            'number' => 7,
        ];

        $this->assertEquals(
            [new PaidMediaPhoto([]), new PaidMediaPreview(100, 100, 23)],
            ValueHelper::getArrayOfPaidMedia($result, 'key')
        );

        $exception = null;
        try {
            ValueHelper::getArrayOfPaidMedia($result, 'unknown');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(NotFoundKeyInResultException::class, $exception);
        $this->assertSame('Not found key "unknown" in result object.', $exception->getMessage());

        $exception = null;
        try {
            ValueHelper::getArrayOfPaidMedia($result, 'number');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(InvalidTypeOfValueInResultException::class, $exception);
        $this->assertSame(
            'Invalid type of value for key "number". Expected type is "array", but got "int".',
            $exception->getMessage()
        );

        $exception = null;
        try {
            ValueHelper::getArrayOfPaidMedia($result, 'array-of-ints');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(TelegramParseResultException::class, $exception);
        $this->assertSame(
            'Expected result as array. Got "int".',
            $exception->getMessage()
        );
    }

    public function testGetArrayOfPhotoSizesOrNull(): void
    {
        $result = [
            'key' => [
                ['file_id' => '1', 'file_unique_id' => 'x1', 'width' => 10, 'height' => 10],
                ['file_id' => '2', 'file_unique_id' => 'x2', 'width' => 15, 'height' => 17],
            ],
            'array-of-ints' => [1, 2],
            'number' => 7,
        ];

        $this->assertEquals(
            [new PhotoSize('1', 'x1', 10, 10), new PhotoSize('2', 'x2', 15, 17)],
            ValueHelper::getArrayOfPhotoSizesOrNull($result, 'key')
        );
        $this->assertNull(ValueHelper::getArrayOfPhotoSizesOrNull($result, 'unknown'));

        $exception = null;
        try {
            ValueHelper::getArrayOfPhotoSizesOrNull($result, 'number');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(InvalidTypeOfValueInResultException::class, $exception);
        $this->assertSame(
            'Invalid type of value for key "number". Expected type is "array", but got "int".',
            $exception->getMessage()
        );

        $exception = null;
        try {
            ValueHelper::getArrayOfPhotoSizesOrNull($result, 'array-of-ints');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(TelegramParseResultException::class, $exception);
        $this->assertSame(
            'Expected result as array. Got "int".',
            $exception->getMessage()
        );
    }

    public function testGetArrayOfUsers(): void
    {
        $result = [
            'key' => [
                ['id' => 1, 'is_bot' => true, 'first_name' => 'A'],
                ['id' => 2, 'is_bot' => false, 'first_name' => 'B'],
            ],
            'array-of-ints' => [1, 2],
            'number' => 7,
        ];

        $this->assertEquals(
            [new User(1, true, 'A'), new User(2, false, 'B')],
            ValueHelper::getArrayOfUsers($result, 'key')
        );

        $exception = null;
        try {
            ValueHelper::getArrayOfUsers($result, 'unknown');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(NotFoundKeyInResultException::class, $exception);
        $this->assertSame('Not found key "unknown" in result object.', $exception->getMessage());

        $exception = null;
        try {
            ValueHelper::getArrayOfUsers($result, 'number');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(InvalidTypeOfValueInResultException::class, $exception);
        $this->assertSame(
            'Invalid type of value for key "number". Expected type is "array", but got "int".',
            $exception->getMessage()
        );

        $exception = null;
        try {
            ValueHelper::getArrayOfUsers($result, 'array-of-ints');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(TelegramParseResultException::class, $exception);
        $this->assertSame(
            'Expected result as array. Got "int".',
            $exception->getMessage()
        );
    }

    public function testGetArrayOfUsersOrNull(): void
    {
        $result = [
            'key' => [
                ['id' => 1, 'is_bot' => true, 'first_name' => 'A'],
                ['id' => 2, 'is_bot' => false, 'first_name' => 'B'],
            ],
            'array-of-ints' => [1, 2],
            'number' => 7,
        ];

        $this->assertEquals(
            [new User(1, true, 'A'), new User(2, false, 'B')],
            ValueHelper::getArrayOfUsersOrNull($result, 'key')
        );
        $this->assertNull(ValueHelper::getArrayOfUsersOrNull($result, 'unknown'));

        $exception = null;
        try {
            ValueHelper::getArrayOfUsersOrNull($result, 'number');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(InvalidTypeOfValueInResultException::class, $exception);
        $this->assertSame(
            'Invalid type of value for key "number". Expected type is "array", but got "int".',
            $exception->getMessage()
        );

        $exception = null;
        try {
            ValueHelper::getArrayOfUsersOrNull($result, 'array-of-ints');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(TelegramParseResultException::class, $exception);
        $this->assertSame(
            'Expected result as array. Got "int".',
            $exception->getMessage()
        );
    }

    public function testGetArrayOfSharedUsers(): void
    {
        $result = [
            'key' => [
                ['user_id' => 1],
                ['user_id' => 2],
            ],
            'array-of-ints' => [1, 2],
            'number' => 7,
        ];

        $this->assertEquals(
            [new SharedUser(1), new SharedUser(2)],
            ValueHelper::getArrayOfSharedUsers($result, 'key')
        );

        $exception = null;
        try {
            ValueHelper::getArrayOfSharedUsers($result, 'unknown');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(NotFoundKeyInResultException::class, $exception);
        $this->assertSame('Not found key "unknown" in result object.', $exception->getMessage());

        $exception = null;
        try {
            ValueHelper::getArrayOfSharedUsers($result, 'number');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(InvalidTypeOfValueInResultException::class, $exception);
        $this->assertSame(
            'Invalid type of value for key "number". Expected type is "array", but got "int".',
            $exception->getMessage()
        );

        $exception = null;
        try {
            ValueHelper::getArrayOfSharedUsers($result, 'array-of-ints');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(TelegramParseResultException::class, $exception);
        $this->assertSame(
            'Expected result as array. Got "int".',
            $exception->getMessage()
        );
    }

    public function testGetArrayOfEncryptedPassportElements(): void
    {
        $result = [
            'key' => [
                ['type' => 'passport', 'hash' => 'x1'],
                ['type' => 'address', 'hash' => 'x2'],
            ],
            'array-of-ints' => [1, 2],
            'number' => 7,
        ];

        $this->assertEquals(
            [new EncryptedPassportElement('passport', 'x1'), new EncryptedPassportElement('address', 'x2')],
            ValueHelper::getArrayOfEncryptedPassportElements($result, 'key')
        );

        $exception = null;
        try {
            ValueHelper::getArrayOfEncryptedPassportElements($result, 'unknown');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(NotFoundKeyInResultException::class, $exception);
        $this->assertSame('Not found key "unknown" in result object.', $exception->getMessage());

        $exception = null;
        try {
            ValueHelper::getArrayOfEncryptedPassportElements($result, 'number');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(InvalidTypeOfValueInResultException::class, $exception);
        $this->assertSame(
            'Invalid type of value for key "number". Expected type is "array", but got "int".',
            $exception->getMessage()
        );

        $exception = null;
        try {
            ValueHelper::getArrayOfEncryptedPassportElements($result, 'array-of-ints');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(TelegramParseResultException::class, $exception);
        $this->assertSame(
            'Expected result as array. Got "int".',
            $exception->getMessage()
        );
    }

    public function testGetArrayOfReactionTypes(): void
    {
        $result = [
            'key' => [
                ['type' => 'emoji', 'emoji' => '❤'],
                ['type' => 'custom_emoji', 'custom_emoji_id' => '=)'],
            ],
            'array-of-ints' => [1, 2],
            'number' => 7,
        ];

        $this->assertEquals(
            [new ReactionTypeEmoji('❤'), new ReactionTypeCustomEmoji('=)')],
            ValueHelper::getArrayOfReactionTypes($result, 'key')
        );

        $exception = null;
        try {
            ValueHelper::getArrayOfReactionTypes($result, 'unknown');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(NotFoundKeyInResultException::class, $exception);
        $this->assertSame('Not found key "unknown" in result object.', $exception->getMessage());

        $exception = null;
        try {
            ValueHelper::getArrayOfReactionTypes($result, 'number');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(InvalidTypeOfValueInResultException::class, $exception);
        $this->assertSame(
            'Invalid type of value for key "number". Expected type is "array", but got "int".',
            $exception->getMessage()
        );

        $exception = null;
        try {
            ValueHelper::getArrayOfReactionTypes($result, 'array-of-ints');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(TelegramParseResultException::class, $exception);
        $this->assertSame(
            'Expected result as array. Got "int".',
            $exception->getMessage()
        );
    }

    public function testGetArrayOfReactionTypesOrNull(): void
    {
        $result = [
            'key' => [
                ['type' => 'emoji', 'emoji' => '❤'],
                ['type' => 'custom_emoji', 'custom_emoji_id' => '=)'],
            ],
            'array-of-ints' => [1, 2],
            'number' => 7,
        ];

        $this->assertEquals(
            [new ReactionTypeEmoji('❤'), new ReactionTypeCustomEmoji('=)')],
            ValueHelper::getArrayOfReactionTypesOrNull($result, 'key')
        );
        $this->assertNull(ValueHelper::getArrayOfReactionTypesOrNull($result, 'unknown'));

        $exception = null;
        try {
            ValueHelper::getArrayOfReactionTypesOrNull($result, 'number');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(InvalidTypeOfValueInResultException::class, $exception);
        $this->assertSame(
            'Invalid type of value for key "number". Expected type is "array", but got "int".',
            $exception->getMessage()
        );

        $exception = null;
        try {
            ValueHelper::getArrayOfReactionTypesOrNull($result, 'array-of-ints');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(TelegramParseResultException::class, $exception);
        $this->assertSame(
            'Expected result as array. Got "int".',
            $exception->getMessage()
        );
    }

    public function testGetArrayOfReactionCounts(): void
    {
        $result = [
            'key' => [
                ['type' => ['type' => 'emoji', 'emoji' => '❤'], 'total_count' => 7],
                ['type' => ['type' => 'custom_emoji', 'custom_emoji_id' => '=)'], 'total_count' => 12],
            ],
            'array-of-ints' => [1, 2],
            'number' => 7,
        ];

        $this->assertEquals(
            [
                new ReactionCount(new ReactionTypeEmoji('❤'), 7),
                new ReactionCount(new ReactionTypeCustomEmoji('=)'), 12)
            ],
            ValueHelper::getArrayOfReactionCounts($result, 'key')
        );

        $exception = null;
        try {
            ValueHelper::getArrayOfReactionCounts($result, 'unknown');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(NotFoundKeyInResultException::class, $exception);
        $this->assertSame('Not found key "unknown" in result object.', $exception->getMessage());

        $exception = null;
        try {
            ValueHelper::getArrayOfReactionCounts($result, 'number');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(InvalidTypeOfValueInResultException::class, $exception);
        $this->assertSame(
            'Invalid type of value for key "number". Expected type is "array", but got "int".',
            $exception->getMessage()
        );

        $exception = null;
        try {
            ValueHelper::getArrayOfReactionCounts($result, 'array-of-ints');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(TelegramParseResultException::class, $exception);
        $this->assertSame(
            'Expected result as array. Got "int".',
            $exception->getMessage()
        );
    }

    public function testGetArrayOfBusinessOpeningHoursIntervals(): void
    {
        $result = [
            'key' => [
                ['opening_minute' => 100, 'closing_minute' => 200],
                ['opening_minute' => 50, 'closing_minute' => 70],
            ],
            'array-of-ints' => [1, 2],
            'number' => 7,
        ];

        $this->assertEquals(
            [new BusinessOpeningHoursInterval(100, 200), new BusinessOpeningHoursInterval(50, 70)],
            ValueHelper::getArrayOfBusinessOpeningHoursIntervals($result, 'key')
        );

        $exception = null;
        try {
            ValueHelper::getArrayOfBusinessOpeningHoursIntervals($result, 'unknown');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(NotFoundKeyInResultException::class, $exception);
        $this->assertSame('Not found key "unknown" in result object.', $exception->getMessage());

        $exception = null;
        try {
            ValueHelper::getArrayOfBusinessOpeningHoursIntervals($result, 'number');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(InvalidTypeOfValueInResultException::class, $exception);
        $this->assertSame(
            'Invalid type of value for key "number". Expected type is "array", but got "int".',
            $exception->getMessage()
        );

        $exception = null;
        try {
            ValueHelper::getArrayOfBusinessOpeningHoursIntervals($result, 'array-of-ints');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(TelegramParseResultException::class, $exception);
        $this->assertSame(
            'Expected result as array. Got "int".',
            $exception->getMessage()
        );
    }

    public function testGetArrayOfStarTransactions(): void
    {
        $result = [
            'key' => [
                ['id' => 'i1', 'amount' => 2, 'date' => 1717498851],
                ['id' => 'i2', 'amount' => 3, 'date' => 1717498852],
            ],
            'array-of-ints' => [1, 2],
            'number' => 7,
        ];

        $this->assertEquals(
            [
                new StarTransaction('i1', 2, new DateTimeImmutable('@1717498851')),
                new StarTransaction('i2', 3, new DateTimeImmutable('@1717498852')),
            ],
            ValueHelper::getArrayOfStarTransactions($result, 'key'),
        );

        $exception = null;
        try {
            ValueHelper::getArrayOfStarTransactions($result, 'unknown');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(NotFoundKeyInResultException::class, $exception);
        $this->assertSame('Not found key "unknown" in result object.', $exception->getMessage());

        $exception = null;
        try {
            ValueHelper::getArrayOfStarTransactions($result, 'number');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(InvalidTypeOfValueInResultException::class, $exception);
        $this->assertSame(
            'Invalid type of value for key "number". Expected type is "array", but got "int".',
            $exception->getMessage()
        );

        $exception = null;
        try {
            ValueHelper::getArrayOfStarTransactions($result, 'array-of-ints');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(TelegramParseResultException::class, $exception);
        $this->assertSame(
            'Expected result as array. Got "int".',
            $exception->getMessage()
        );
    }

    public function testGetArrayOfStickers(): void
    {
        $result = [
            'key' => [
                [
                    'file_id' => 'fid1',
                    'file_unique_id' => 'fuid1',
                    'type' => 'regular',
                    'width' => 200,
                    'height' => 300,
                    'is_animated' => false,
                    'is_video' => false,
                ],
                [
                    'file_id' => 'fid2',
                    'file_unique_id' => 'fuid2',
                    'type' => 'regular',
                    'width' => 512,
                    'height' => 256,
                    'is_animated' => true,
                    'is_video' => true,
                ],
            ],
            'array-of-ints' => [1, 2],
            'number' => 7,
        ];

        $this->assertEquals(
            [
                new Sticker('fid1', 'fuid1', 'regular', 200, 300, false, false),
                new Sticker('fid2', 'fuid2', 'regular', 512, 256, true, true),
            ],
            ValueHelper::getArrayOfStickers($result, 'key'),
        );
        $this->assertEquals(
            [
                new Sticker('fid1', 'fuid1', 'regular', 200, 300, false, false),
                new Sticker('fid2', 'fuid2', 'regular', 512, 256, true, true),
            ],
            ValueHelper::getArrayOfStickers($result['key']),
        );

        $exception = null;
        try {
            ValueHelper::getArrayOfStickers($result, 'unknown');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(NotFoundKeyInResultException::class, $exception);
        $this->assertSame('Not found key "unknown" in result object.', $exception->getMessage());

        $exception = null;
        try {
            ValueHelper::getArrayOfStickers($result, 'number');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(InvalidTypeOfValueInResultException::class, $exception);
        $this->assertSame(
            'Invalid type of value for key "number". Expected type is "array", but got "int".',
            $exception->getMessage()
        );

        $exception = null;
        try {
            ValueHelper::getArrayOfStickers($result, 'array-of-ints');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(TelegramParseResultException::class, $exception);
        $this->assertSame(
            'Expected result as array. Got "int".',
            $exception->getMessage()
        );
    }

    public function testGetArrayOfChatBoosts(): void
    {
        $result = [
            'key' => [
                [
                    'boost_id' => 'b1',
                    'add_date' => 1619040000,
                    'expiration_date' => 1619040001,
                    'source' => [
                        'source' => 'premium',
                        'user' => [
                            'id' => 1,
                            'is_bot' => false,
                            'first_name' => 'Sergei',
                        ],
                    ],
                ],
            ],
            'array-of-ints' => [1, 2],
            'number' => 7,
        ];

        $this->assertEquals(
            [
                new ChatBoost(
                    'b1',
                    new DateTimeImmutable('@1619040000'),
                    new DateTimeImmutable('@1619040001'),
                    new ChatBoostSourcePremium(new User(1, false, 'Sergei')),
                )
            ],
            ValueHelper::getArrayOfChatBoosts($result, 'key'),
        );
        $this->assertEquals(
            [
                new ChatBoost(
                    'b1',
                    new DateTimeImmutable('@1619040000'),
                    new DateTimeImmutable('@1619040001'),
                    new ChatBoostSourcePremium(new User(1, false, 'Sergei')),
                )
            ],
            ValueHelper::getArrayOfChatBoosts($result['key']),
        );

        $exception = null;
        try {
            ValueHelper::getArrayOfChatBoosts($result, 'unknown');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(NotFoundKeyInResultException::class, $exception);
        $this->assertSame('Not found key "unknown" in result object.', $exception->getMessage());

        $exception = null;
        try {
            ValueHelper::getArrayOfChatBoosts($result, 'number');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(InvalidTypeOfValueInResultException::class, $exception);
        $this->assertSame(
            'Invalid type of value for key "number". Expected type is "array", but got "int".',
            $exception->getMessage()
        );

        $exception = null;
        try {
            ValueHelper::getArrayOfChatBoosts($result, 'array-of-ints');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(TelegramParseResultException::class, $exception);
        $this->assertSame(
            'Expected result as array. Got "int".',
            $exception->getMessage()
        );
    }

    public function testGetArrayOfPassportFilesOrNull(): void
    {
        $result = [
            'key' => [
                ['file_id' => '1', 'file_unique_id' => 'x1', 'file_size' => 100, 'file_date' => 1068605423],
                ['file_id' => '2', 'file_unique_id' => 'x2', 'file_size' => 134, 'file_date' => 1118844017],
            ],
            'array-of-ints' => [1, 2],
            'number' => 7,
        ];

        $this->assertEquals(
            [
                new PassportFile('1', 'x1', 100, new DateTimeImmutable('2003-11-12T02:50:23.000000+0000')),
                new PassportFile('2', 'x2', 134, new DateTimeImmutable('2005-06-15T14:00:17.000000+0000'))
            ],
            ValueHelper::getArrayOfPassportFilesOrNull($result, 'key')
        );
        $this->assertNull(ValueHelper::getArrayOfPassportFilesOrNull($result, 'unknown'));

        $exception = null;
        try {
            ValueHelper::getArrayOfPassportFilesOrNull($result, 'number');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(InvalidTypeOfValueInResultException::class, $exception);
        $this->assertSame(
            'Invalid type of value for key "number". Expected type is "array", but got "int".',
            $exception->getMessage()
        );

        $exception = null;
        try {
            ValueHelper::getArrayOfPassportFilesOrNull($result, 'array-of-ints');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(TelegramParseResultException::class, $exception);
        $this->assertSame(
            'Expected result as array. Got "int".',
            $exception->getMessage()
        );
    }

    public function testGetArrayOfArrayOfInlineKeyboardButtons(): void
    {
        $result = [
            'key' => [
                [['text' => 'a']],
                [['text' => 'b']],
            ],
            'array-of-array-of-ints' => [[1], [2]],
            'array-of-ints' => [1, 2],
            'number' => 7,
        ];

        $this->assertEquals(
            [[new InlineKeyboardButton('a')], [new InlineKeyboardButton('b')]],
            ValueHelper::getArrayOfArrayOfInlineKeyboardButtons($result, 'key')
        );

        $exception = null;
        try {
            ValueHelper::getArrayOfArrayOfInlineKeyboardButtons($result, 'unknown');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(NotFoundKeyInResultException::class, $exception);
        $this->assertSame('Not found key "unknown" in result object.', $exception->getMessage());

        $exception = null;
        try {
            ValueHelper::getArrayOfArrayOfInlineKeyboardButtons($result, 'number');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(InvalidTypeOfValueInResultException::class, $exception);
        $this->assertSame(
            'Invalid type of value for key "number". Expected type is "array", but got "int".',
            $exception->getMessage()
        );

        $exception = null;
        try {
            ValueHelper::getArrayOfArrayOfInlineKeyboardButtons($result, 'array-of-array-of-ints');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(TelegramParseResultException::class, $exception);
        $this->assertSame(
            'Expected result as array. Got "int".',
            $exception->getMessage()
        );

        $exception = null;
        try {
            ValueHelper::getArrayOfArrayOfInlineKeyboardButtons($result, 'array-of-ints');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(TelegramParseResultException::class, $exception);
        $this->assertSame(
            'Invalid type of value for key "array-of-ints". Expected type is "array[]", but got "array".',
            $exception->getMessage()
        );
    }

    public function testGetArrayOfArrayOfPhotoSize(): void
    {

        $result = [
            'key' => [
                [
                    [
                        'file_id' => 'f1',
                        'file_unique_id' => 'fu1',
                        'width' => 100,
                        'height' => 200,
                    ],
                ],
                [
                    [
                        'file_id' => 'f2',
                        'file_unique_id' => 'fu2',
                        'width' => 1,
                        'height' => 2,
                    ],
                ],
            ],
            'array-of-array-of-ints' => [[1], [2]],
            'array-of-ints' => [1, 2],
            'number' => 7,
        ];

        $this->assertEquals(
            [[new PhotoSize('f1','fu1',100,200)], [new PhotoSize('f2','fu2', 1,2)]],
            ValueHelper::getArrayOfArrayOfPhotoSize($result, 'key')
        );

        $exception = null;
        try {
            ValueHelper::getArrayOfArrayOfPhotoSize($result, 'unknown');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(NotFoundKeyInResultException::class, $exception);
        $this->assertSame('Not found key "unknown" in result object.', $exception->getMessage());

        $exception = null;
        try {
            ValueHelper::getArrayOfArrayOfPhotoSize($result, 'number');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(InvalidTypeOfValueInResultException::class, $exception);
        $this->assertSame(
            'Invalid type of value for key "number". Expected type is "array", but got "int".',
            $exception->getMessage()
        );

        $exception = null;
        try {
            ValueHelper::getArrayOfArrayOfPhotoSize($result, 'array-of-array-of-ints');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(TelegramParseResultException::class, $exception);
        $this->assertSame(
            'Expected result as array. Got "int".',
            $exception->getMessage()
        );

        $exception = null;
        try {
            ValueHelper::getArrayOfArrayOfPhotoSize($result, 'array-of-ints');
        } catch (Throwable $exception) {
        }
        $this->assertInstanceOf(TelegramParseResultException::class, $exception);
        $this->assertSame(
            'Invalid type of value for key "array-of-ints". Expected type is "array[]", but got "array".',
            $exception->getMessage()
        );
    }
}

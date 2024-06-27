<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\ParseResult;

use DateTimeImmutable;
use Vjik\TelegramBot\Api\Type\BusinessOpeningHoursInterval;
use Vjik\TelegramBot\Api\Type\InlineKeyboardButton;
use Vjik\TelegramBot\Api\Type\MessageEntity;
use Vjik\TelegramBot\Api\Type\Passport\EncryptedPassportElement;
use Vjik\TelegramBot\Api\Type\Passport\PassportFile;
use Vjik\TelegramBot\Api\Type\Payments\StarTransaction;
use Vjik\TelegramBot\Api\Type\PhotoSize;
use Vjik\TelegramBot\Api\Type\ReactionCount;
use Vjik\TelegramBot\Api\Type\ReactionType;
use Vjik\TelegramBot\Api\Type\ReactionTypeFactory;
use Vjik\TelegramBot\Api\Type\SharedUser;
use Vjik\TelegramBot\Api\Type\User;

final class ValueHelper
{
    /**
     * @psalm-assert array $result
     */
    public static function assertArrayResult(mixed $result): void
    {
        if (!is_array($result)) {
            throw new TelegramParseResultException(
                'Expected result as array. Got "' . get_debug_type($result) . '".'
            );
        }
    }

    /**
     * @psalm-assert string $result
     */
    public static function assertStringResult(mixed $result): void
    {
        if (!is_string($result)) {
            throw new TelegramParseResultException(
                'Expected result as string. Got "' . get_debug_type($result) . '".'
            );
        }
    }

    /**
     * @psalm-assert true $result
     */
    public static function assertTrueResult(mixed $result): void
    {
        if ($result !== true) {
            throw new TelegramParseResultException(
                'Expected result as true. Got "' . get_debug_type($result) . '".'
            );
        }
    }

    public static function getString(array $result, string $key): string
    {
        if (!isset($result[$key])) {
            throw new NotFoundKeyInResultException($key);
        }
        $value = $result[$key];
        if (!is_string($value)) {
            throw new InvalidTypeOfValueInResultException($key, $value, 'string');
        }
        return $value;
    }

    public static function getStringOrNull(array $result, string $key): ?string
    {
        if (!isset($result[$key])) {
            return null;
        }
        $value = $result[$key];
        if (!is_string($value)) {
            throw new InvalidTypeOfValueInResultException($key, $value, 'string');
        }
        return $value;
    }

    public static function getBoolean(array $result, string $key): bool
    {
        if (!isset($result[$key])) {
            throw new NotFoundKeyInResultException($key);
        }
        $value = $result[$key];
        if (!is_bool($value)) {
            throw new InvalidTypeOfValueInResultException($key, $value, 'boolean');
        }
        return $value;
    }

    public static function getBooleanOrNull(array $result, string $key): ?bool
    {
        if (!isset($result[$key])) {
            return null;
        }
        $value = $result[$key];
        if (!is_bool($value)) {
            throw new InvalidTypeOfValueInResultException($key, $value, 'boolean');
        }
        return $value;
    }

    public static function getTrueOrNull(array $result, string $key): ?true
    {
        if (!isset($result[$key])) {
            return null;
        }
        $value = $result[$key];
        if ($value !== true) {
            throw new InvalidTypeOfValueInResultException($key, $value, 'true');
        }
        return $value;
    }

    public static function getInteger(array $result, string $key): int
    {
        if (!isset($result[$key])) {
            throw new NotFoundKeyInResultException($key);
        }
        $value = $result[$key];
        if (!is_int($value)) {
            throw new InvalidTypeOfValueInResultException($key, $value, 'integer');
        }
        return $value;
    }

    public static function getIntegerOrNull(array $result, string $key): ?int
    {
        if (!isset($result[$key])) {
            return null;
        }
        $value = $result[$key];
        if (!is_int($value)) {
            throw new InvalidTypeOfValueInResultException($key, $value, 'integer');
        }
        return $value;
    }

    public static function getFloat(array $result, string $key): float
    {
        if (!isset($result[$key])) {
            throw new NotFoundKeyInResultException($key);
        }
        $value = $result[$key];
        if (!is_int($value) && !is_float($value)) {
            throw new InvalidTypeOfValueInResultException($key, $value, 'float');
        }
        return $value;
    }

    public static function getFloatOrNull(array $result, string $key): ?float
    {
        if (!isset($result[$key])) {
            return null;
        }
        $value = $result[$key];
        if (!is_int($value) && !is_float($value)) {
            throw new InvalidTypeOfValueInResultException($key, $value, 'float');
        }
        return $value;
    }

    public static function getDateTimeImmutable(array $result, string $key): DateTimeImmutable
    {
        if (!isset($result[$key])) {
            throw new NotFoundKeyInResultException($key);
        }
        $value = $result[$key];
        if (!is_int($value)) {
            throw new InvalidTypeOfValueInResultException($key, $value, 'integer');
        }
        return (new DateTimeImmutable())->setTimestamp($value);
    }

    public static function getDateTimeImmutableOrNull(array $result, string $key): ?DateTimeImmutable
    {
        if (!isset($result[$key])) {
            return null;
        }
        $value = $result[$key];
        if (!is_int($value)) {
            throw new InvalidTypeOfValueInResultException($key, $value, 'integer');
        }
        return (new DateTimeImmutable())->setTimestamp($value);
    }

    public static function getArray(array $result, string $key): array
    {
        if (!isset($result[$key])) {
            throw new NotFoundKeyInResultException($key);
        }
        $value = $result[$key];
        if (!is_array($value)) {
            throw new InvalidTypeOfValueInResultException($key, $value, 'array');
        }
        return $value;
    }

    public static function getArrayOrNull(array $result, string $key): ?array
    {
        if (!isset($result[$key])) {
            return null;
        }
        $value = $result[$key];
        if (!is_array($value)) {
            throw new InvalidTypeOfValueInResultException($key, $value, 'array');
        }
        return $value;
    }

    /**
     * @return array[]
     */
    public static function getArrayOfArrays(array $result, string $key): array
    {
        $value = ValueHelper::getArray($result, $key);

        foreach ($value as $v) {
            if (!is_array($v)) {
                throw new InvalidTypeOfValueInResultException($key, $value, 'array[]');
            }
        }
        /** @var array[] $value */

        return $value;
    }

    /**
     * @return string[]|null
     */
    public static function getArrayOfStringsOrNull(array $result, string $key): ?array
    {
        if (!isset($result[$key])) {
            return null;
        }

        $value = $result[$key];
        if (!is_array($value)) {
            throw new InvalidTypeOfValueInResultException($key, $value, 'string[]');
        }

        foreach ($value as $v) {
            if (!is_string($v)) {
                throw new InvalidTypeOfValueInResultException($key, $value, 'string[]');
            }
        }
        /** @var string[] $value */

        return $value;
    }

    /**
     * @return int[]
     */
    public static function getArrayOfIntegers(array $result, string $key): array
    {
        if (!isset($result[$key])) {
            throw new NotFoundKeyInResultException($key);
        }

        $value = $result[$key];
        if (!is_array($value)) {
            throw new InvalidTypeOfValueInResultException($key, $value, 'array');
        }

        foreach ($value as $v) {
            if (!is_int($v)) {
                throw new InvalidTypeOfValueInResultException($key, $value, 'int[]');
            }
        }
        /** @var int[] $value */

        return $value;
    }

    /**
     * @return MessageEntity[]|null
     */
    public static function getArrayOfMessageEntitiesOrNull(array $result, string $key): ?array
    {
        $entities = ValueHelper::getArrayOrNull($result, $key);
        return $entities === null
            ? null
            : array_map(
                static fn($item) => MessageEntity::fromTelegramResult($item),
                $entities
            );
    }

    /**
     * @return PhotoSize[]
     */
    public static function getArrayOfPhotoSizes(array $result, string $key): array
    {
        $photo = ValueHelper::getArray($result, $key);
        return array_map(
            static fn($item) => PhotoSize::fromTelegramResult($item),
            $photo
        );
    }

    /**
     * @return PhotoSize[]|null
     */
    public static function getArrayOfPhotoSizesOrNull(array $result, string $key): ?array
    {
        $photo = ValueHelper::getArrayOrNull($result, $key);
        return $photo === null
            ? null
            : array_map(
                static fn($item) => PhotoSize::fromTelegramResult($item),
                $photo
            );
    }

    /**
     * @return User[]
     */
    public static function getArrayOfUsers(array $result, string $key): array
    {
        $users = ValueHelper::getArray($result, $key);
        return array_map(
            static fn($item) => User::fromTelegramResult($item),
            $users
        );
    }

    /**
     * @return User[]|null
     */
    public static function getArrayOfUsersOrNull(array $result, string $key): ?array
    {
        $users = ValueHelper::getArrayOrNull($result, $key);
        return $users === null
            ? null
            : array_map(
                static fn($item) => User::fromTelegramResult($item),
                $users
            );
    }

    /**
     * @return SharedUser[]
     */
    public static function getArrayOfSharedUsers(array $result, string $key): array
    {
        $users = ValueHelper::getArray($result, $key);
        return array_map(
            static fn($item) => SharedUser::fromTelegramResult($item),
            $users
        );
    }

    /**
     * @return EncryptedPassportElement[]
     */
    public static function getArrayOfEncryptedPassportElements(array $result, string $key): array
    {
        $encryptedPassportElements = ValueHelper::getArray($result, $key);
        return array_map(
            static fn($item) => EncryptedPassportElement::fromTelegramResult($item),
            $encryptedPassportElements
        );
    }

    /**
     * @return ReactionType[]
     */
    public static function getArrayOfReactionTypes(array $result, string $key): array
    {
        $reactionTypes = ValueHelper::getArray($result, $key);
        return array_map(
            static fn($item) => ReactionTypeFactory::fromTelegramResult($item),
            $reactionTypes
        );
    }

    /**
     * @return ReactionType[]|null
     */
    public static function getArrayOfReactionTypesOrNull(array $result, string $key): ?array
    {
        $reactionTypes = ValueHelper::getArrayOrNull($result, $key);
        return $reactionTypes === null
            ? null
            : array_map(
                static fn($item) => ReactionTypeFactory::fromTelegramResult($item),
                $reactionTypes
            );
    }

    /**
     * @return ReactionCount[]
     */
    public static function getArrayOfReactionCounts(array $result, string $key): array
    {
        $reactionCounts = ValueHelper::getArray($result, $key);
        return array_map(
            static fn($item) => ReactionCount::fromTelegramResult($item),
            $reactionCounts
        );
    }

    /**
     * @return BusinessOpeningHoursInterval[]
     */
    public static function getArrayOfBusinessOpeningHoursIntervals(array $result, string $key): array
    {
        $intervals = ValueHelper::getArray($result, $key);
        return array_map(
            static fn($item) => BusinessOpeningHoursInterval::fromTelegramResult($item),
            $intervals
        );
    }

    /**
     * @return StarTransaction[]
     */
    public static function getArrayOfStarTransactions(array $result, string $key): array
    {
        $transactions = ValueHelper::getArray($result, $key);
        return array_map(
            static fn($item) => StarTransaction::fromTelegramResult($item),
            $transactions
        );
    }

    /**
     * @return PassportFile[]|null
     */
    public static function getArrayOfPassportFilesOrNull(array $result, string $key): ?array
    {
        $passportFiles = ValueHelper::getArrayOrNull($result, $key);
        return $passportFiles === null
            ? null
            : array_map(
                static fn($item) => PassportFile::fromTelegramResult($item),
                $passportFiles
            );
    }

    /**
     * @return array[]
     * @psalm-return array<array-key, array<array-key, InlineKeyboardButton>>
     */
    public static function getArrayOfArrayOfInlineKeyboardButtons(array $result, string $key): array
    {
        $arrayOfArrays = ValueHelper::getArrayOfArrays($result, $key);
        return array_map(
            static fn(array $array) => array_map(
                static fn($item) => InlineKeyboardButton::fromTelegramResult($item),
                $array
            ),
            $arrayOfArrays
        );
    }

    /**
     * @return array[]
     * @psalm-return array<array-key, array<array-key, PhotoSize>>
     */
    public static function getArrayOfArrayOfPhotoSize(array $result, string $key): array
    {
        $arrayOfArrays = ValueHelper::getArrayOfArrays($result, $key);
        return array_map(
            static fn(array $array) => array_map(
                static fn($item) => PhotoSize::fromTelegramResult($item),
                $array
            ),
            $arrayOfArrays
        );
    }
}

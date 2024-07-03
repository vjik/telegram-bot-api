<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\ParseResult;

use DateTimeImmutable;
use Vjik\TelegramBot\Api\Type\BusinessOpeningHoursInterval;
use Vjik\TelegramBot\Api\Type\ChatBoost;
use Vjik\TelegramBot\Api\Type\InlineKeyboardButton;
use Vjik\TelegramBot\Api\Type\MessageEntity;
use Vjik\TelegramBot\Api\Type\PaidMedia;
use Vjik\TelegramBot\Api\Type\PaidMediaFactory;
use Vjik\TelegramBot\Api\Type\Passport\EncryptedPassportElement;
use Vjik\TelegramBot\Api\Type\Passport\PassportFile;
use Vjik\TelegramBot\Api\Type\Payment\StarTransaction;
use Vjik\TelegramBot\Api\Type\PhotoSize;
use Vjik\TelegramBot\Api\Type\ReactionCount;
use Vjik\TelegramBot\Api\Type\ReactionType;
use Vjik\TelegramBot\Api\Type\ReactionTypeFactory;
use Vjik\TelegramBot\Api\Type\SharedUser;
use Vjik\TelegramBot\Api\Type\Sticker\Sticker;
use Vjik\TelegramBot\Api\Type\User;

final class ValueHelper
{
    /**
     * @psalm-assert array $result
     */
    public static function assertArrayResult(mixed $result, mixed $raw = null): void
    {
        if (!is_array($result)) {
            throw new TelegramParseResultException(
                'Expected result as array. Got "' . get_debug_type($result) . '".',
                raw: $raw ?? $result,
            );
        }
    }

    /**
     * @psalm-assert string $result
     */
    public static function assertStringResult(mixed $result, mixed $raw = null): void
    {
        if (!is_string($result)) {
            throw new TelegramParseResultException(
                'Expected result as string. Got "' . get_debug_type($result) . '".',
                raw: $raw ?? $result,
            );
        }
    }

    /**
     * @psalm-assert int $result
     */
    public static function assertIntegerResult(mixed $result, mixed $raw = null): void
    {
        if (!is_int($result)) {
            throw new TelegramParseResultException(
                'Expected result as integer. Got "' . get_debug_type($result) . '".',
                raw: $raw ?? $result,
            );
        }
    }

    /**
     * @psalm-assert true $result
     */
    public static function assertTrueResult(mixed $result, mixed $raw = null): void
    {
        if ($result !== true) {
            throw new TelegramParseResultException(
                'Expected result as true. Got "' . get_debug_type($result) . '".',
                raw: $raw ?? $result,
            );
        }
    }

    public static function getString(array $result, string $key, mixed $raw = null): string
    {
        if (!isset($result[$key])) {
            throw new NotFoundKeyInResultException($key, $raw ?? $result);
        }
        $value = $result[$key];
        if (!is_string($value)) {
            throw new InvalidTypeOfValueInResultException($key, $value, 'string', $raw ?? $result);
        }
        return $value;
    }

    public static function getStringOrNull(array $result, string $key, mixed $raw = null): ?string
    {
        if (!isset($result[$key])) {
            return null;
        }
        $value = $result[$key];
        if (!is_string($value)) {
            throw new InvalidTypeOfValueInResultException($key, $value, 'string', $raw ?? $result);
        }
        return $value;
    }

    public static function getBoolean(array $result, string $key, mixed $raw = null): bool
    {
        if (!isset($result[$key])) {
            throw new NotFoundKeyInResultException($key, $raw ?? $result);
        }
        $value = $result[$key];
        if (!is_bool($value)) {
            throw new InvalidTypeOfValueInResultException($key, $value, 'boolean', $raw ?? $result);
        }
        return $value;
    }

    public static function getBooleanOrNull(array $result, string $key, mixed $raw = null): ?bool
    {
        if (!isset($result[$key])) {
            return null;
        }
        $value = $result[$key];
        if (!is_bool($value)) {
            throw new InvalidTypeOfValueInResultException($key, $value, 'boolean', $raw ?? $result);
        }
        return $value;
    }

    public static function getTrueOrNull(array $result, string $key, mixed $raw = null): ?true
    {
        if (!isset($result[$key])) {
            return null;
        }
        $value = $result[$key];
        if ($value !== true) {
            throw new InvalidTypeOfValueInResultException($key, $value, 'true', $raw ?? $result);
        }
        return $value;
    }

    public static function getInteger(array $result, string $key, mixed $raw = null): int
    {
        if (!isset($result[$key])) {
            throw new NotFoundKeyInResultException($key, $raw ?? $result);
        }
        $value = $result[$key];
        if (!is_int($value)) {
            throw new InvalidTypeOfValueInResultException($key, $value, 'integer', $raw ?? $result);
        }
        return $value;
    }

    public static function getIntegerOrNull(array $result, string $key, mixed $raw = null): ?int
    {
        if (!isset($result[$key])) {
            return null;
        }
        $value = $result[$key];
        if (!is_int($value)) {
            throw new InvalidTypeOfValueInResultException($key, $value, 'integer', $raw ?? $result);
        }
        return $value;
    }

    public static function getFloat(array $result, string $key, mixed $raw = null): float
    {
        if (!isset($result[$key])) {
            throw new NotFoundKeyInResultException($key, $raw ?? $result);
        }
        $value = $result[$key];
        if (!is_int($value) && !is_float($value)) {
            throw new InvalidTypeOfValueInResultException($key, $value, 'float', $raw ?? $result);
        }
        return $value;
    }

    public static function getFloatOrNull(array $result, string $key, mixed $raw = null): ?float
    {
        if (!isset($result[$key])) {
            return null;
        }
        $value = $result[$key];
        if (!is_int($value) && !is_float($value)) {
            throw new InvalidTypeOfValueInResultException($key, $value, 'float', $raw ?? $result);
        }
        return $value;
    }

    public static function getDateTimeImmutable(array $result, string $key, mixed $raw = null): DateTimeImmutable
    {
        if (!isset($result[$key])) {
            throw new NotFoundKeyInResultException($key, $raw ?? $result);
        }
        $value = $result[$key];
        if (!is_int($value)) {
            throw new InvalidTypeOfValueInResultException($key, $value, 'integer', $raw ?? $result);
        }
        return (new DateTimeImmutable())->setTimestamp($value);
    }

    public static function getDateTimeImmutableOrNull(array $result, string $key, mixed $raw = null): ?DateTimeImmutable
    {
        if (!isset($result[$key])) {
            return null;
        }
        $value = $result[$key];
        if (!is_int($value)) {
            throw new InvalidTypeOfValueInResultException($key, $value, 'integer', $raw ?? $result);
        }
        return (new DateTimeImmutable())->setTimestamp($value);
    }

    public static function getArray(array $result, string $key, mixed $raw = null): array
    {
        if (!isset($result[$key])) {
            throw new NotFoundKeyInResultException($key, $raw ?? $result);
        }
        $value = $result[$key];
        if (!is_array($value)) {
            throw new InvalidTypeOfValueInResultException($key, $value, 'array', $raw ?? $result);
        }
        return $value;
    }

    public static function getArrayOrNull(array $result, string $key, mixed $raw = null): ?array
    {
        if (!isset($result[$key])) {
            return null;
        }
        $value = $result[$key];
        if (!is_array($value)) {
            throw new InvalidTypeOfValueInResultException($key, $value, 'array', $raw ?? $result);
        }
        return $value;
    }

    /**
     * @return array[]
     */
    public static function getArrayOfArrays(array $result, string $key, mixed $raw = null): array
    {
        $raw ??= $result;
        $value = ValueHelper::getArray($result, $key, $raw);

        foreach ($value as $v) {
            if (!is_array($v)) {
                throw new InvalidTypeOfValueInResultException($key, $value, 'array[]', $raw);
            }
        }
        /** @var array[] $value */

        return $value;
    }

    /**
     * @return string[]|null
     */
    public static function getArrayOfStringsOrNull(array $result, string $key, mixed $raw = null): ?array
    {
        if (!isset($result[$key])) {
            return null;
        }

        $value = $result[$key];
        if (!is_array($value)) {
            throw new InvalidTypeOfValueInResultException($key, $value, 'string[]', $raw ?? $result);
        }

        foreach ($value as $v) {
            if (!is_string($v)) {
                throw new InvalidTypeOfValueInResultException($key, $value, 'string[]', $raw ?? $result);
            }
        }
        /** @var string[] $value */

        return $value;
    }

    /**
     * @return int[]
     */
    public static function getArrayOfIntegers(array $result, string $key, mixed $raw = null): array
    {
        if (!isset($result[$key])) {
            throw new NotFoundKeyInResultException($key, $raw ?? $result);
        }

        $value = $result[$key];
        if (!is_array($value)) {
            throw new InvalidTypeOfValueInResultException($key, $value, 'array', $raw ?? $result);
        }

        foreach ($value as $v) {
            if (!is_int($v)) {
                throw new InvalidTypeOfValueInResultException($key, $value, 'int[]', $raw ?? $result);
            }
        }
        /** @var int[] $value */

        return $value;
    }

    /**
     * @return MessageEntity[]|null
     */
    public static function getArrayOfMessageEntitiesOrNull(array $result, string $key, mixed $raw = null): ?array
    {
        $raw ??= $result;
        $entities = ValueHelper::getArrayOrNull($result, $key, $raw);
        return $entities === null
            ? null
            : array_map(
                static fn($item) => MessageEntity::fromTelegramResult($item, $raw),
                $entities
            );
    }

    /**
     * @return PhotoSize[]
     */
    public static function getArrayOfPhotoSizes(array $result, string $key, mixed $raw = null): array
    {
        $raw ??= $result;
        $photo = ValueHelper::getArray($result, $key, $raw);
        return array_map(
            static fn($item) => PhotoSize::fromTelegramResult($item, $raw),
            $photo
        );
    }

    /**
     * @return PaidMedia[]
     */
    public static function getArrayOfPaidMedia(array $result, string $key, mixed $raw = null): array
    {
        $raw ??= $result;
        $items = ValueHelper::getArray($result, $key, $raw);
        return array_map(
            static fn($item) => PaidMediaFactory::fromTelegramResult($item, $raw),
            $items
        );
    }

    /**
     * @return PhotoSize[]|null
     */
    public static function getArrayOfPhotoSizesOrNull(array $result, string $key, mixed $raw = null): ?array
    {
        $raw ??= $result;
        $photo = ValueHelper::getArrayOrNull($result, $key, $raw);
        return $photo === null
            ? null
            : array_map(
                static fn($item) => PhotoSize::fromTelegramResult($item, $raw),
                $photo
            );
    }

    /**
     * @return User[]
     */
    public static function getArrayOfUsers(array $result, string $key, mixed $raw = null): array
    {
        $raw ??= $result;
        $users = ValueHelper::getArray($result, $key, $raw);
        return array_map(
            static fn($item) => User::fromTelegramResult($item, $raw),
            $users
        );
    }

    /**
     * @return User[]|null
     */
    public static function getArrayOfUsersOrNull(array $result, string $key, mixed $raw = null): ?array
    {
        $raw ??= $result;
        $users = ValueHelper::getArrayOrNull($result, $key, $raw);
        return $users === null
            ? null
            : array_map(
                static fn($item) => User::fromTelegramResult($item, $raw),
                $users
            );
    }

    /**
     * @return SharedUser[]
     */
    public static function getArrayOfSharedUsers(array $result, string $key, mixed $raw = null): array
    {
        $raw ??= $result;
        $users = ValueHelper::getArray($result, $key, $raw);
        return array_map(
            static fn($item) => SharedUser::fromTelegramResult($item, $raw),
            $users
        );
    }

    /**
     * @return EncryptedPassportElement[]
     */
    public static function getArrayOfEncryptedPassportElements(array $result, string $key, mixed $raw = null): array
    {
        $raw ??= $result;
        $encryptedPassportElements = ValueHelper::getArray($result, $key, $raw);
        return array_map(
            static fn($item) => EncryptedPassportElement::fromTelegramResult($item, $raw),
            $encryptedPassportElements
        );
    }

    /**
     * @return ReactionType[]
     */
    public static function getArrayOfReactionTypes(array $result, string $key, mixed $raw = null): array
    {
        $raw ??= $result;
        $reactionTypes = ValueHelper::getArray($result, $key, $raw);
        return array_map(
            static fn($item) => ReactionTypeFactory::fromTelegramResult($item, $raw),
            $reactionTypes
        );
    }

    /**
     * @return ReactionType[]|null
     */
    public static function getArrayOfReactionTypesOrNull(array $result, string $key, mixed $raw = null): ?array
    {
        $raw ??= $result;
        $reactionTypes = ValueHelper::getArrayOrNull($result, $key, $raw);
        return $reactionTypes === null
            ? null
            : array_map(
                static fn($item) => ReactionTypeFactory::fromTelegramResult($item, $raw),
                $reactionTypes
            );
    }

    /**
     * @return ReactionCount[]
     */
    public static function getArrayOfReactionCounts(array $result, string $key, mixed $raw = null): array
    {
        $raw ??= $result;
        $reactionCounts = ValueHelper::getArray($result, $key, $raw);
        return array_map(
            static fn($item) => ReactionCount::fromTelegramResult($item, $raw),
            $reactionCounts
        );
    }

    /**
     * @return BusinessOpeningHoursInterval[]
     */
    public static function getArrayOfBusinessOpeningHoursIntervals(array $result, string $key, mixed $raw = null): array
    {
        $raw ??= $result;
        $intervals = ValueHelper::getArray($result, $key, $raw);
        return array_map(
            static fn($item) => BusinessOpeningHoursInterval::fromTelegramResult($item, $raw),
            $intervals
        );
    }

    /**
     * @return StarTransaction[]
     */
    public static function getArrayOfStarTransactions(array $result, string $key, mixed $raw = null): array
    {
        $raw ??= $result;
        $transactions = ValueHelper::getArray($result, $key, $raw);
        return array_map(
            static fn($item) => StarTransaction::fromTelegramResult($item, $raw),
            $transactions
        );
    }

    /**
     * @return Sticker[]
     */
    public static function getArrayOfStickers(array $result, ?string $key = null, mixed $raw = null): array
    {
        $raw ??= $result;
        $stickers = $key === null ? $result : ValueHelper::getArray($result, $key, $raw);
        return array_map(
            static fn($item) => Sticker::fromTelegramResult($item, $raw),
            $stickers
        );
    }

    /**
     * @return ChatBoost[]
     */
    public static function getArrayOfChatBoosts(array $result, ?string $key = null, mixed $raw = null): array
    {
        $raw ??= $result;
        $stickers = $key === null ? $result : ValueHelper::getArray($result, $key, $raw);
        return array_map(
            static fn($item) => ChatBoost::fromTelegramResult($item, $raw),
            $stickers
        );
    }

    /**
     * @return PassportFile[]|null
     */
    public static function getArrayOfPassportFilesOrNull(array $result, string $key, mixed $raw = null): ?array
    {
        $raw ??= $result;
        $passportFiles = ValueHelper::getArrayOrNull($result, $key, $raw);
        return $passportFiles === null
            ? null
            : array_map(
                static fn($item) => PassportFile::fromTelegramResult($item, $raw),
                $passportFiles
            );
    }

    /**
     * @return array[]
     * @psalm-return array<array-key, array<array-key, InlineKeyboardButton>>
     */
    public static function getArrayOfArrayOfInlineKeyboardButtons(array $result, string $key, mixed $raw = null): array
    {
        $raw ??= $result;
        $arrayOfArrays = ValueHelper::getArrayOfArrays($result, $key, $raw);
        return array_map(
            static fn(array $array) => array_map(
                static fn($item) => InlineKeyboardButton::fromTelegramResult($item, $raw),
                $array
            ),
            $arrayOfArrays
        );
    }

    /**
     * @return array[]
     * @psalm-return array<array-key, array<array-key, PhotoSize>>
     */
    public static function getArrayOfArrayOfPhotoSize(array $result, string $key, mixed $raw = null): array
    {
        $raw ??= $result;
        $arrayOfArrays = ValueHelper::getArrayOfArrays($result, $key, $raw);
        return array_map(
            static fn(array $array) => array_map(
                static fn($item) => PhotoSize::fromTelegramResult($item, $raw),
                $array
            ),
            $arrayOfArrays
        );
    }
}

<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\ParseResult;

use DateTimeImmutable;

final class ValueHelper
{
    /**
     * @psalm-assert array $result
     */
    public static function assertArrayResult(mixed $result): void
    {
        if (!is_array($result)) {
            throw new TelegramParseResultException(
                'Expected result as array. Got ' . get_debug_type($result) . '.'
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
}

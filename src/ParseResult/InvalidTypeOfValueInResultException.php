<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\ParseResult;

final class InvalidTypeOfValueInResultException extends TelegramParseResultException
{
    public function __construct(string $key, mixed $value, string $expectedType, mixed $raw)
    {
        parent::__construct(
            'Invalid type of value for key "' .
            $key .
            '". Expected type is "' .
            $expectedType .
            '", but got "' .
            get_debug_type($value) . '".',
            raw: $raw,
        );
    }
}

<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\ParseResult\ValueProcessor;

use Vjik\TelegramBot\Api\ParseResult\InvalidTypeOfValueInResultException;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;

final readonly class StringValue implements ValueProcessorInterface
{
    public function process(mixed $value, ?string $key, ObjectFactory $objectFactory): string
    {
        if (!is_string($value)) {
            throw new InvalidTypeOfValueInResultException($key, $value, 'string');
        }
        return $value;
    }
}

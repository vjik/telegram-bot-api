<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\ParseResult\ValueProcessor;

use Vjik\TelegramBot\Api\ParseResult\InvalidTypeOfValueInResultException;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;

use function is_bool;

/**
 * @template-implements ValueProcessorInterface<bool>
 */
final readonly class BooleanValue implements ValueProcessorInterface
{
    public function process(mixed $value, ?string $key, ObjectFactory $objectFactory): bool
    {
        if (!is_bool($value)) {
            throw new InvalidTypeOfValueInResultException($key, $value, 'boolean');
        }
        return $value;
    }
}

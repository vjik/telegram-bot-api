<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\ParseResult\ValueProcessor;

use Vjik\TelegramBot\Api\ParseResult\InvalidTypeOfValueInResultException;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;

use function is_float;

/**
 * @template-implements ValueProcessorInterface<float>
 */
final readonly class FloatValue implements ValueProcessorInterface
{
    public function process(mixed $value, ?string $key, ObjectFactory $objectFactory): float
    {
        if (!is_float($value)) {
            throw new InvalidTypeOfValueInResultException($key, $value, 'float');
        }
        return $value;
    }
}

<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\ParseResult\ValueProcessor;

use Vjik\TelegramBot\Api\ParseResult\InvalidTypeOfValueInResultException;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;

/**
 * @template-implements ValueProcessorInterface<true>
 */
final readonly class TrueValue implements ValueProcessorInterface
{
    public function process(mixed $value, ?string $key, ObjectFactory $objectFactory): true
    {
        if ($value !== true) {
            throw new InvalidTypeOfValueInResultException($key, $value, 'true');
        }
        return $value;
    }
}

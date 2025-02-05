<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\ParseResult\ValueProcessor;

use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;

/**
 * @template TValue
 * @template-implements ValueProcessorInterface<TValue>
 *
 * @api
 */
final readonly class RawValue implements ValueProcessorInterface
{
    /**
     * @psalm-param TValue $value
     */
    public function process(mixed $value, ?string $key, ObjectFactory $objectFactory): mixed
    {
        return $value;
    }
}

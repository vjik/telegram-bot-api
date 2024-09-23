<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\ParseResult\ValueProcessor;

use DateTimeImmutable;
use Vjik\TelegramBot\Api\ParseResult\InvalidTypeOfValueInResultException;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;

use function is_int;

/**
 * @template-implements ValueProcessorInterface<DateTimeImmutable>
 */
final readonly class DateValue implements ValueProcessorInterface
{
    public function process(mixed $value, ?string $key, ObjectFactory $objectFactory): DateTimeImmutable
    {
        if (!is_int($value)) {
            throw new InvalidTypeOfValueInResultException($key, $value, 'integer');
        }
        return (new DateTimeImmutable())->setTimestamp($value);
    }
}

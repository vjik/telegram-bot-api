<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\ParseResult\ValueProcessor;

use Attribute;
use Vjik\TelegramBot\Api\ParseResult\InvalidTypeOfValueInResultException;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;

use function is_array;

/**
 * @template T
 * @template-implements ValueProcessorInterface<array<array-key,T>>
 */
#[Attribute(Attribute::TARGET_PARAMETER)]
final readonly class ArrayOfObjectsValue implements ValueProcessorInterface
{
    /**
     * @psalm-param class-string<T> $className
     */
    public function __construct(
        private string $className,
    ) {}

    /**
     * @psalm-return array<array-key,T>
     */
    public function process(mixed $value, ?string $key, ObjectFactory $objectFactory): mixed
    {
        if (!is_array($value)) {
            throw new InvalidTypeOfValueInResultException($key, $value, 'array');
        }
        return array_map(
            fn($item) => $objectFactory->create($item, $key, $this->className),
            $value,
        );
    }
}

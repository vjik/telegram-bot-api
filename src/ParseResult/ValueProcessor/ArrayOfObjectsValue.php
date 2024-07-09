<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\ParseResult\ValueProcessor;

use Attribute;
use Vjik\TelegramBot\Api\ParseResult\InvalidTypeOfValueInResultException;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;

#[Attribute(Attribute::TARGET_PARAMETER)]
final readonly class ArrayOfObjectsValue implements ValueProcessorInterface
{
    /**
     * @param class-string $className
     */
    public function __construct(
        private string $className,
    ) {
    }

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

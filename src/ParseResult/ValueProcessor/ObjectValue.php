<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\ParseResult\ValueProcessor;

use Vjik\TelegramBot\Api\ParseResult\InvalidTypeOfValueInResultException;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;

final readonly class ObjectValue implements ValueProcessorInterface
{
    /**
     * @psalm-param class-string $className
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

        return $objectFactory->create($value, $key, $this->className);
    }
}

<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\ParseResult\ValueProcessor;

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
        return $objectFactory->create($value, $key, $this->className);
    }
}

<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\ParseResult\ValueProcessor;

use Attribute;
use Vjik\TelegramBot\Api\ParseResult\InvalidTypeOfValueInResultException;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;

#[Attribute(Attribute::TARGET_PARAMETER)]
final readonly class ArrayMap implements ValueProcessorInterface
{
    /**
     * @psalm-param class-string<ValueProcessorInterface> $className
     */
    public function __construct(
        private string $className,
    ) {}

    public function process(mixed $value, ?string $key, ObjectFactory $objectFactory): mixed
    {
        if (!is_array($value)) {
            throw new InvalidTypeOfValueInResultException($key, $value, 'array');
        }

        $className = $this->className;
        $valueProcessor = new $className();
        return array_map(
            fn($item): mixed => $valueProcessor->process($item, $key, $objectFactory),
            $value,
        );
    }
}

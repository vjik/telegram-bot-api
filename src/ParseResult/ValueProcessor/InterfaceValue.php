<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\ParseResult\ValueProcessor;

use Vjik\TelegramBot\Api\ParseResult\InvalidTypeOfValueInResultException;
use Vjik\TelegramBot\Api\ParseResult\NotFoundKeyInResultException;
use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;

use function is_array;
use function is_string;

/**
 * @template T as object
 * @template-implements ValueProcessorInterface<T>
 */
abstract readonly class InterfaceValue implements ValueProcessorInterface
{
    /**
     * @psalm-return T
     */
    final public function process(mixed $value, ?string $key, ObjectFactory $objectFactory): mixed
    {
        if (!is_array($value)) {
            throw new InvalidTypeOfValueInResultException($key, $value, 'array');
        }

        $typeKey = $this->getTypeKey();
        if (!isset($value[$typeKey])) {
            throw new NotFoundKeyInResultException($typeKey);
        }

        if (!is_string($value[$typeKey])) {
            throw new InvalidTypeOfValueInResultException($typeKey, $value[$typeKey], 'string');
        }

        $className = $this->getClassMap()[$value[$typeKey]]
            ?? throw new TelegramParseResultException($this->getUnknownTypeMessage());

        return $objectFactory->create($value, $key, $className);
    }

    abstract public function getTypeKey(): string;

    /**
     * @psalm-return array<string,class-string<T>>
     */
    abstract public function getClassMap(): array;

    abstract public function getUnknownTypeMessage(): string;
}

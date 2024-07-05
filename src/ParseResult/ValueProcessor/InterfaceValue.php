<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\ParseResult\ValueProcessor;

use Vjik\TelegramBot\Api\ParseResult\InvalidTypeOfValueInResultException;
use Vjik\TelegramBot\Api\ParseResult\NotFoundKeyInResultException;
use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;

abstract readonly class InterfaceValue implements ValueProcessorInterface
{
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
            throw new InvalidTypeOfValueInResultException($key, $value[$typeKey], 'string');
        }

        $className = $this->getClassMap()[$value[$typeKey]]
            ?? throw new TelegramParseResultException($this->getUnknownTypeMessage());

        return $objectFactory->create($value, $key, $className);
    }

    abstract public function getTypeKey(): string;

    /**
     * @psalm-return array<string,class-string>
     */
    abstract public function getClassMap(): array;

    abstract public function getUnknownTypeMessage(): string;
}

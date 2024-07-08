<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\ParseResult\ValueProcessor;

use Attribute;
use Vjik\TelegramBot\Api\ParseResult\InvalidTypeOfValueInResultException;
use Vjik\TelegramBot\Api\ParseResult\NotFoundKeyInResultException;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\InaccessibleMessage;
use Vjik\TelegramBot\Api\Type\Message;

#[Attribute(Attribute::TARGET_PARAMETER)]
final readonly class MaybeInaccessibleMessageValue implements ValueProcessorInterface
{
    public function process(mixed $value, ?string $key, ObjectFactory $objectFactory): mixed
    {
        if (!is_array($value)) {
            throw new InvalidTypeOfValueInResultException($key, $value, 'array', $value);
        }

        $date = $value['date'] ?? null;
        if ($date === null) {
            throw new NotFoundKeyInResultException('date', $value);
        }
        if (!is_int($date)) {
            throw new InvalidTypeOfValueInResultException('date', $date, 'integer', $value);
        }

        return $date === 0
            ? $objectFactory->create($value, $key, InaccessibleMessage::class)
            : $objectFactory->create($value, $key, Message::class);
    }
}

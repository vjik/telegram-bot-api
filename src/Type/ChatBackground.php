<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\NotFoundKeyInResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#chatbackground
 */
final readonly class ChatBackground
{
    public function __construct(
        public BackgroundType $type,
    ) {
    }

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            array_key_exists('type', $result)
                ? BackgroundTypeFactory::fromTelegramResult($result['type'])
                : throw new NotFoundKeyInResultException('type'),
        );
    }
}

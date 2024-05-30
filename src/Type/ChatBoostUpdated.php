<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\NotFoundKeyInResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#chatboostupdated
 */
final readonly class ChatBoostUpdated
{
    public function __construct(
        public Chat $chat,
        public ChatBoost $boost,
    ) {
    }

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            array_key_exists('chat', $result)
                ? Chat::fromTelegramResult($result['chat'])
                : throw new NotFoundKeyInResultException('chat'),
            array_key_exists('boost', $result)
                ? ChatBoost::fromTelegramResult($result['boost'])
                : throw new NotFoundKeyInResultException('boost'),
        );
    }
}

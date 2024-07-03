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

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            array_key_exists('chat', $result)
                ? Chat::fromTelegramResult($result['chat'], $raw)
                : throw new NotFoundKeyInResultException('chat', $raw),
            array_key_exists('boost', $result)
                ? ChatBoost::fromTelegramResult($result['boost'], $raw)
                : throw new NotFoundKeyInResultException('boost', $raw),
        );
    }
}

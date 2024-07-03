<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use DateTimeImmutable;
use Vjik\TelegramBot\Api\ParseResult\NotFoundKeyInResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#chatboostremoved
 */
final readonly class ChatBoostRemoved
{
    public function __construct(
        public Chat $chat,
        public string $boostId,
        public DateTimeImmutable $removeDate,
        public ChatBoostSource $source,
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
            ValueHelper::getString($result, 'boost_id', $raw),
            ValueHelper::getDateTimeImmutable($result, 'remove_date', $raw),
            array_key_exists('source', $result)
                ? ChatBoostSourceFactory::fromTelegramResult($result['source'], $raw)
                : throw new NotFoundKeyInResultException('source', $raw),
        );
    }
}

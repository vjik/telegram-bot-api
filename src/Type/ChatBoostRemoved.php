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

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            array_key_exists('chat', $result)
                ? Chat::fromTelegramResult($result['chat'])
                : throw new NotFoundKeyInResultException('chat'),
            ValueHelper::getString($result, 'boost_id'),
            ValueHelper::getDateTimeImmutable($result, 'remove_date'),
            array_key_exists('source', $result)
                ? ChatBoostSourceFactory::fromTelegramResult($result['source'])
                : throw new NotFoundKeyInResultException('source'),
        );
    }
}

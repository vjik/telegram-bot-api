<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use DateTimeImmutable;
use Vjik\TelegramBot\Api\ParseResult\NotFoundKeyInResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#chatboost
 */
final readonly class ChatBoost
{
    public function __construct(
        public string $boostId,
        public DateTimeImmutable $addDate,
        public DateTimeImmutable $expirationDate,
        public ChatBoostSource $source,
    ) {
    }

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            ValueHelper::getString($result, 'boost_id'),
            ValueHelper::getDateTimeImmutable($result, 'add_date'),
            ValueHelper::getDateTimeImmutable($result, 'expiration_date'),
            array_key_exists('source', $result)
                ? ChatBoostSourceFactory::fromTelegramResult($result['source'])
                : throw new NotFoundKeyInResultException('source'),
        );
    }
}

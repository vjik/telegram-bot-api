<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Payment;

use DateTimeImmutable;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#startransaction
 */
final readonly class StarTransaction
{
    public function __construct(
        public string $id,
        public int $amount,
        public DateTimeImmutable $date,
        public ?TransactionPartner $source = null,
        public ?TransactionPartner $receiver = null,
    ) {
    }

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            ValueHelper::getString($result, 'id'),
            ValueHelper::getInteger($result, 'amount'),
            ValueHelper::getDateTimeImmutable($result, 'date'),
            array_key_exists('source', $result) ? TransactionPartnerFactory::fromTelegramResult($result['source']) : null,
            array_key_exists('receiver', $result) ? TransactionPartnerFactory::fromTelegramResult($result['receiver']) : null,
        );
    }
}

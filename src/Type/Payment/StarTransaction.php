<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Payment;

use DateTimeImmutable;

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
    ) {}
}

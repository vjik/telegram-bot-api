<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Payment;

use DateTimeImmutable;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#revenuewithdrawalstatesucceeded
 */
final readonly class RevenueWithdrawalStateSucceeded implements RevenueWithdrawalState
{
    public function __construct(
        public DateTimeImmutable $date,
        public string $url,
    ) {
    }

    public function getType(): string
    {
        return 'succeeded';
    }

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            ValueHelper::getDateTimeImmutable($result, 'date', $raw),
            ValueHelper::getString($result, 'url', $raw),
        );
    }
}

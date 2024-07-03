<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Payment;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#startransactions
 */
final readonly class StarTransactions
{
    /**
     * @param StarTransaction[] $transactions
     */
    public function __construct(
        public array $transactions,
    ) {
    }

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            ValueHelper::getArrayOfStarTransactions($result, 'transactions', $raw),
        );
    }
}

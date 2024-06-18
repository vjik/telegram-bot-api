<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Payments;

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

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            ValueHelper::getArrayOfStarTransactions($result, 'transactions'),
        );
    }
}

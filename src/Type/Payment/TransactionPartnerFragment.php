<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Payment;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#transactionpartnerfragment
 */
final readonly class TransactionPartnerFragment implements TransactionPartner
{
    public function __construct(
        public ?RevenueWithdrawalState $withdrawalState = null,
    ) {
    }

    public function getType(): string
    {
        return 'fragment';
    }

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            array_key_exists('withdrawal_state', $result)
                ? RevenueWithdrawalStateFactory::fromTelegramResult($result['withdrawal_state'], $raw)
                : null,
        );
    }
}

<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Payment;

use Vjik\TelegramBot\Api\Type\User;

/**
 * @see https://core.telegram.org/bots/api#transactionpartneruser
 */
final readonly class TransactionPartnerUser implements TransactionPartner
{
    public function __construct(
        public User $user,
        public ?string $invoicePayload = null,
    ) {}

    public function getType(): string
    {
        return 'user';
    }
}

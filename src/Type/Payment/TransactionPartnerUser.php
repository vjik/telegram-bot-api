<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Payment;

use Vjik\TelegramBot\Api\ParseResult\NotFoundKeyInResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;
use Vjik\TelegramBot\Api\Type\User;

/**
 * @see https://core.telegram.org/bots/api#transactionpartneruser
 */
final readonly class TransactionPartnerUser implements TransactionPartner
{
    public function __construct(
        public User $user,
        public ?string $invoicePayload = null,
    ) {
    }

    public function getType(): string
    {
        return 'user';
    }

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            array_key_exists('user', $result)
                ? User::fromTelegramResult($result['user'], $raw)
                : throw new NotFoundKeyInResultException('user', $raw),
            ValueHelper::getStringOrNull($result, 'invoice_payload', $raw),
        );
    }
}

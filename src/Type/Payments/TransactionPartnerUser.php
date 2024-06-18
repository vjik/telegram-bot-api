<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Payments;

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
    ) {
    }

    public function getType(): string
    {
        return 'user';
    }

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            array_key_exists('user', $result)
                ? User::fromTelegramResult($result['user'])
                : throw new NotFoundKeyInResultException('user'),
        );
    }
}

<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Payments;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#transactionpartnerother
 */
final readonly class TransactionPartnerOther implements TransactionPartner
{
    public function getType(): string
    {
        return 'other';
    }

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self();
    }
}

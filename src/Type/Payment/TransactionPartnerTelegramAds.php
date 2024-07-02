<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Payment;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#transactionpartnertelegramads
 */
final readonly class TransactionPartnerTelegramAds implements TransactionPartner
{
    public function getType(): string
    {
        return 'telegram_ads';
    }

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self();
    }
}

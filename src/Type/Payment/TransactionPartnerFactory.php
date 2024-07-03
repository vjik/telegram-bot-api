<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Payment;

use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

final readonly class TransactionPartnerFactory
{
    public static function fromTelegramResult(mixed $result, mixed $raw = null): TransactionPartner
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return match (ValueHelper::getString($result, 'type', $raw)) {
            'fragment' => TransactionPartnerFragment::fromTelegramResult($result, $raw),
            'telegram_ads' => TransactionPartnerTelegramAds::fromTelegramResult($result, $raw),
            'user' => TransactionPartnerUser::fromTelegramResult($result, $raw),
            'other' => TransactionPartnerOther::fromTelegramResult($result, $raw),
            default => throw new TelegramParseResultException('Unknown transaction partner type.', $raw),
        };
    }
}

<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Payments;

use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

final readonly class TransactionPartnerFactory
{
    public static function fromTelegramResult(mixed $result): TransactionPartner
    {
        ValueHelper::assertArrayResult($result);
        return match (ValueHelper::getString($result, 'type')) {
            'fragment' => TransactionPartnerFragment::fromTelegramResult($result),
            'user' => TransactionPartnerUser::fromTelegramResult($result),
            'other' => TransactionPartnerOther::fromTelegramResult($result),
            default => throw new TelegramParseResultException('Unknown transaction partner type.'),
        };
    }
}

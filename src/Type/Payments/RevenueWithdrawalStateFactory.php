<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Payments;

use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

final readonly class RevenueWithdrawalStateFactory
{
    public static function fromTelegramResult(mixed $result): RevenueWithdrawalState
    {
        ValueHelper::assertArrayResult($result);
        return match (ValueHelper::getString($result, 'type')) {
            'pending' => RevenueWithdrawalStatePending::fromTelegramResult($result),
            'succeeded' => RevenueWithdrawalStateSucceeded::fromTelegramResult($result),
            'failed' => RevenueWithdrawalStateFailed::fromTelegramResult($result),
            default => throw new TelegramParseResultException('Unknown revenue withdrawal state type.'),
        };
    }
}

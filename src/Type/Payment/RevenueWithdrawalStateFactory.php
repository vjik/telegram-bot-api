<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Payment;

use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

final readonly class RevenueWithdrawalStateFactory
{
    public static function fromTelegramResult(mixed $result, mixed $raw = null): RevenueWithdrawalState
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return match (ValueHelper::getString($result, 'type', $raw)) {
            'pending' => RevenueWithdrawalStatePending::fromTelegramResult($result, $raw),
            'succeeded' => RevenueWithdrawalStateSucceeded::fromTelegramResult($result, $raw),
            'failed' => RevenueWithdrawalStateFailed::fromTelegramResult($result, $raw),
            default => throw new TelegramParseResultException('Unknown revenue withdrawal state type.', $raw),
        };
    }
}

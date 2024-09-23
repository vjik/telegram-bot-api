<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\ParseResult\ValueProcessor;

use Vjik\TelegramBot\Api\Type\Payment\RevenueWithdrawalState;
use Vjik\TelegramBot\Api\Type\Payment\RevenueWithdrawalStateFailed;
use Vjik\TelegramBot\Api\Type\Payment\RevenueWithdrawalStatePending;
use Vjik\TelegramBot\Api\Type\Payment\RevenueWithdrawalStateSucceeded;

/**
 * @template-extends InterfaceValue<RevenueWithdrawalState>
 */
final readonly class RevenueWithdrawalStateValue extends InterfaceValue
{
    public function getTypeKey(): string
    {
        return 'type';
    }

    public function getClassMap(): array
    {
        return [
            'pending' => RevenueWithdrawalStatePending::class,
            'succeeded' => RevenueWithdrawalStateSucceeded::class,
            'failed' => RevenueWithdrawalStateFailed::class,
        ];
    }

    public function getUnknownTypeMessage(): string
    {
        return 'Unknown revenue withdrawal state type.';
    }
}

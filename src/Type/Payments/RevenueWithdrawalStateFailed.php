<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Payments;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#revenuewithdrawalstatefailed
 */
final readonly class RevenueWithdrawalStateFailed implements RevenueWithdrawalState
{
    public function getType(): string
    {
        return 'failed';
    }

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self();
    }
}

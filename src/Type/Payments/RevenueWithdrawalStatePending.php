<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Payments;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#revenuewithdrawalstatepending
 */
final readonly class RevenueWithdrawalStatePending implements RevenueWithdrawalState
{
    public function getType(): string
    {
        return 'pending';
    }

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self();
    }
}

<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method\Payment;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\TrueValue;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\TelegramRequestWithResultPreparingInterface;

/**
 * @see https://core.telegram.org/bots/api#refundstarpayment
 *
 * @template-implements TelegramRequestWithResultPreparingInterface<TrueValue>
 */
final readonly class RefundStarPayment implements TelegramRequestWithResultPreparingInterface
{
    public function __construct(
        private int $userId,
        private string $telegramPaymentChargeId,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'refundStarPayment';
    }

    public function getData(): array
    {
        return [
            'user_id' => $this->userId,
            'telegram_payment_charge_id' => $this->telegramPaymentChargeId,
        ];
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}

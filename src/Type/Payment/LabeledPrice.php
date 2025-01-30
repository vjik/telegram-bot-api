<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Payment;

/**
 * @see https://core.telegram.org/bots/api#labeledprice
 *
 * @api
 */
final readonly class LabeledPrice
{
    public function __construct(
        public string $label,
        public int $amount,
    ) {}

    public function toRequestArray(): array
    {
        return [
            'label' => $this->label,
            'amount' => $this->amount,
        ];
    }
}

<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Payment;

/**
 * @see https://core.telegram.org/bots/api#shippingoption
 */
final readonly class ShippingOption
{
    /**
     * @param LabeledPrice[] $prices
     */
    public function __construct(
        public string $id,
        public string $title,
        public array $prices,
    ) {}

    public function toRequestArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'prices' => array_map(
                static fn(LabeledPrice $price) => $price->toRequestArray(),
                $this->prices,
            ),
        ];
    }
}

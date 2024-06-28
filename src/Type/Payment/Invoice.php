<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Payment;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#invoice
 */
final readonly class Invoice
{
    public function __construct(
        public string $title,
        public string $description,
        public string $startParameter,
        public string $currency,
        public int $totalAmount,
    ) {
    }

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            ValueHelper::getString($result, 'title'),
            ValueHelper::getString($result, 'description'),
            ValueHelper::getString($result, 'start_parameter'),
            ValueHelper::getString($result, 'currency'),
            ValueHelper::getInteger($result, 'total_amount'),
        );
    }
}

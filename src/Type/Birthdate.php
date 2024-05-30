<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#birthdate
 */
final readonly class Birthdate
{
    public function __construct(
        public int $day,
        public int $month,
        public ?int $year,
    ) {
    }

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            ValueHelper::getInteger($result, 'day'),
            ValueHelper::getInteger($result, 'month'),
            ValueHelper::getIntegerOrNull($result, 'year'),
        );
    }
}

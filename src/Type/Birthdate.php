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
        public ?int $year = null,
    ) {
    }

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            ValueHelper::getInteger($result, 'day', $raw),
            ValueHelper::getInteger($result, 'month', $raw),
            ValueHelper::getIntegerOrNull($result, 'year', $raw),
        );
    }
}

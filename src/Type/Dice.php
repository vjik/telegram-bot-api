<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#dice
 */
final readonly class Dice
{
    public function __construct(
        public string $emoji,
        public int $value,
    ) {
    }

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            ValueHelper::getString($result, 'emoji', $raw),
            ValueHelper::getInteger($result, 'value', $raw),
        );
    }
}

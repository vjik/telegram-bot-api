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

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            ValueHelper::getString($result, 'emoji'),
            ValueHelper::getInteger($result, 'value'),
        );
    }
}

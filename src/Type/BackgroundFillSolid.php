<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#backgroundfillsolid
 */
final readonly class BackgroundFillSolid implements BackgroundFill
{
    public function __construct(
        public int $color,
    ) {
    }

    public function getType(): string
    {
        return 'solid';
    }

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            ValueHelper::getInteger($result, 'color', $raw),
        );
    }
}

<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

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
}

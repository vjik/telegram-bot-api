<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#backgroundfillgradient
 */
final readonly class BackgroundFillGradient implements BackgroundFill
{
    public function __construct(
        public int $topColor,
        public int $bottomColor,
        public int $rotationAngle,
    ) {
    }

    public function getType(): string
    {
        return 'gradient';
    }
}

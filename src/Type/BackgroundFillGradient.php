<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

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

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            ValueHelper::getInteger($result, 'top_color'),
            ValueHelper::getInteger($result, 'bottom_color'),
            ValueHelper::getInteger($result, 'rotation_angle'),
        );
    }
}

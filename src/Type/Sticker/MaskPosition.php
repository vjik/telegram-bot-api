<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Sticker;

/**
 * @see https://core.telegram.org/bots/api#maskposition
 */
final readonly class MaskPosition
{
    public function __construct(
        public string $point,
        public float $xShift,
        public float $yShift,
        public float $scale,
    ) {}

    public function toRequestArray(): array
    {
        return [
            'point' => $this->point,
            'x_shift' => $this->xShift,
            'y_shift' => $this->yShift,
            'scale' => $this->scale,
        ];
    }
}

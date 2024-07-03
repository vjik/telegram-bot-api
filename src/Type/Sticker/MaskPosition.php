<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Sticker;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

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
    ) {
    }

    public function toRequestArray(): array
    {
        return [
            'point' => $this->point,
            'x_shift' => $this->xShift,
            'y_shift' => $this->yShift,
            'scale' => $this->scale,
        ];
    }

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            ValueHelper::getString($result, 'point', $raw),
            ValueHelper::getFloat($result, 'x_shift', $raw),
            ValueHelper::getFloat($result, 'y_shift', $raw),
            ValueHelper::getFloat($result, 'scale', $raw),
        );
    }
}

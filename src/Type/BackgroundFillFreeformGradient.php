<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#backgroundfillfreeformgradient
 */
final readonly class BackgroundFillFreeformGradient implements BackgroundFill
{
    /**
     * @param int[] $colors
     */
    public function __construct(
        public array $colors,
    ) {
    }

    public function getType(): string
    {
        return 'freeform_gradient';
    }

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            ValueHelper::getArrayOfIntegers($result, 'colors'),
        );
    }
}

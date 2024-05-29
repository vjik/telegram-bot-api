<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

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
}

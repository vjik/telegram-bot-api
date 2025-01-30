<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ArrayMap;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\IntegerValue;

/**
 * @see https://core.telegram.org/bots/api#backgroundfillfreeformgradient
 *
 * @api
 */
final readonly class BackgroundFillFreeformGradient implements BackgroundFill
{
    /**
     * @param int[] $colors
     */
    public function __construct(
        #[ArrayMap(IntegerValue::class)]
        public array $colors,
    ) {}

    public function getType(): string
    {
        return 'freeform_gradient';
    }
}

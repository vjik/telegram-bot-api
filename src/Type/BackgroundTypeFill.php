<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#backgroundtypefill
 */
final readonly class BackgroundTypeFill implements BackgroundType
{
    public function __construct(
        public BackgroundFill $fill,
        public int $darkThemeDimming,
    ) {
    }

    function getType(): string
    {
        return 'fill';
    }
}

<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#backgroundtypepattern
 */
final readonly class BackgroundTypePattern implements BackgroundType
{
    public function __construct(
        public Document $document,
        public BackgroundFill $fill,
        public int $intensity,
        public ?true $isInverted = null,
        public ?true $isMoving = null,
    ) {
    }

    function getType(): string
    {
        return 'pattern';
    }
}

<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

final readonly class BackgroundTypeWallpaper implements BackgroundType
{
    public function __construct(
        public Document $document,
        public int $darkThemeDimming,
        public ?true $isBlurred = null,
        public ?true $isMoving = null,
    ) {}

    public function getType(): string
    {
        return 'wallpaper';
    }
}

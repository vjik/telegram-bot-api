<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Enum\Sticker;

enum StickerFormat: string
{
    case STATIC = 'static';
    case ANIMATED = 'animated';
    case VIDEO = 'video';
}

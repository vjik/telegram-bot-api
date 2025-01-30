<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#backgroundtype
 *
 * @api
 */
interface BackgroundType
{
    public function getType(): string;
}

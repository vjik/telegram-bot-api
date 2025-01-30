<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#backgroundfill
 *
 * @api
 */
interface BackgroundFill
{
    public function getType(): string;
}

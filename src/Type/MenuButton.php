<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#menubutton
 *
 * @api
 */
interface MenuButton
{
    public function getType(): string;

    public function toRequestArray(): array;
}

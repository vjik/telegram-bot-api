<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use DateTimeImmutable;

/**
 * @see https://core.telegram.org/bots/api#messageorigin
 *
 * @api
 */
interface MessageOrigin
{
    public function getType(): string;

    public function getDate(): DateTimeImmutable;
}

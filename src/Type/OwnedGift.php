<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#ownedgift
 *
 * @api
 */
interface OwnedGift
{
    public function getType(): string;
}

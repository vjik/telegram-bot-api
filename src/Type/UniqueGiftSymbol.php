<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\Type\Sticker\Sticker;

/**
 * @see https://core.telegram.org/bots/api#uniquegiftsymbol
 *
 * @api
 */
final readonly class UniqueGiftSymbol
{
    public function __construct(
        public string $name,
        public Sticker $sticker,
        public int $rarityPerMille,
    ) {}
}

<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ArrayMap;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\OwnedGiftValue;

/**
 * @see https://core.telegram.org/bots/api#ownedgifts
 *
 * @api
 */
final readonly class OwnedGifts
{
    /**
     * @param OwnedGift[] $gifts
     */
    public function __construct(
        public int $totalCount,
        #[ArrayMap(OwnedGiftValue::class)]
        public array $gifts,
        public ?string $nextOffset = null,
    ) {}
}

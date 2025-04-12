<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#uniquegiftinfo
 *
 * @api
 */
final readonly class UniqueGiftInfo
{
    public function __construct(
        public UniqueGift $gift,
        public string $origin,
        public ?string $ownedGiftId = null,
        public ?int $transferStarCount = null,
    ) {
    }
}

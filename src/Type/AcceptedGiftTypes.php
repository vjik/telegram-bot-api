<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#acceptedgifttypes
 *
 * @api
 */
final readonly class AcceptedGiftTypes
{
    public function __construct(
        public bool $unlimitedGifts,
        public bool $limitedGifts,
        public bool $uniqueGifts,
        public bool $premiumSubscription,
    ) {}

    public function toRequestArray(): array
    {
        return [
            'unlimited_gifts' => $this->unlimitedGifts,
            'limited_gifts' => $this->limitedGifts,
            'unique_gifts' => $this->uniqueGifts,
            'premium_subscription' => $this->premiumSubscription,
        ];
    }
}

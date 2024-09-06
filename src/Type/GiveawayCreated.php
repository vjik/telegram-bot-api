<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#giveawaycreated
 */
final readonly class GiveawayCreated
{
    public function __construct(
        public ?int $prizeStarCount = null,
    ) {
    }
}

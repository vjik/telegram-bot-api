<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Sticker;

/**
 * @see https://core.telegram.org/bots/api#gift
 *
 * @api
 */
final readonly class Gift
{
    public function __construct(
        public string $id,
        public Sticker $sticker,
        public int $starCount,
        public ?int $totalCount = null,
        public ?int $remainingCount = null,
        public ?int $upgradeStarCount = null,
    ) {}
}

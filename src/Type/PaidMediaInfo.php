<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#paidmediainfo
 */
final readonly class PaidMediaInfo
{
    /**
     * @param PaidMedia[] $paidMedia
     */
    public function __construct(
        public int $starCount,
        public array $paidMedia,
    ) {
    }

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            ValueHelper::getInteger($result, 'star_count'),
            ValueHelper::getArrayOfPaidMedia($result, 'paid_media'),
        );
    }
}

<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ArrayOfValueProcessors;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\PaidMediaValue;

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
        #[ArrayOfValueProcessors(PaidMediaValue::class)]
        public array $paidMedia,
    ) {
    }
}

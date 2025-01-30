<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Sticker;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ArrayOfObjectsValue;

/**
 * @see https://core.telegram.org/bots/api#gifts
 *
 * @api
 */
final readonly class Gifts
{
    /**
     * @param Gift[] $gifts
     */
    public function __construct(
        #[ArrayOfObjectsValue(Gift::class)]
        public array $gifts,
    ) {}
}

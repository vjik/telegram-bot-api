<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ArrayOfObjectsValue;

/**
 * @see https://core.telegram.org/bots/api#paidmediaphoto
 *
 * @api
 */
final readonly class PaidMediaPhoto implements PaidMedia
{
    /**
     * @param PhotoSize[] $photo
     */
    public function __construct(
        #[ArrayOfObjectsValue(PhotoSize::class)]
        public array $photo,
    ) {}

    public function getType(): string
    {
        return 'photo';
    }
}

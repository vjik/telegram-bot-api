<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#paidmediapreview
 */
final readonly class PaidMediaPreview implements PaidMedia
{
    public function __construct(
        public ?int $width = null,
        public ?int $height = null,
        public ?int $duration = null,
    ) {}

    public function getType(): string
    {
        return 'preview';
    }
}

<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#paidmediavideo
 */
final readonly class PaidMediaVideo implements PaidMedia
{
    public function __construct(
        public Video $video,
    ) {}

    public function getType(): string
    {
        return 'video';
    }
}

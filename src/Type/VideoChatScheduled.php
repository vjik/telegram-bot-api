<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#videochatscheduled
 */
final readonly class VideoChatScheduled
{
    public function __construct(
        public int $startDate,
    ) {
    }
}

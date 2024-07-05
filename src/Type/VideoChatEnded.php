<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#videochatended
 */
final readonly class VideoChatEnded
{
    public function __construct(
        public int $duration,
    ) {
    }
}

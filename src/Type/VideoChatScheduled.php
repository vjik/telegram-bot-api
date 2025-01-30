<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use DateTimeImmutable;

/**
 * @see https://core.telegram.org/bots/api#videochatscheduled
 *
 * @api
 */
final readonly class VideoChatScheduled
{
    public function __construct(
        public DateTimeImmutable $startDate,
    ) {}
}

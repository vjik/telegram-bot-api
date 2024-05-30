<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use DateTimeImmutable;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#videochatscheduled
 */
final readonly class VideoChatScheduled
{
    public function __construct(
        public DateTimeImmutable $startDate,
    ) {
    }

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            ValueHelper::getDateTimeImmutable($result, 'start_date'),
        );
    }
}

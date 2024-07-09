<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#birthdate
 */
final readonly class Birthdate
{
    public function __construct(
        public int $day,
        public int $month,
        public ?int $year = null,
    ) {}
}

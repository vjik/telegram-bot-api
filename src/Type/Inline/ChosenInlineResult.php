<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type\Inline;

use Vjik\TelegramBot\Api\Type\Location;
use Vjik\TelegramBot\Api\Type\User;

/**
 * @see https://core.telegram.org/bots/api#choseninlineresult
 */
final readonly class ChosenInlineResult
{
    public function __construct(
        public string $resultId,
        public User $from,
        public ?Location $location,
        public ?string $inlineMessageId,
        public string $query,
    ) {
    }
}

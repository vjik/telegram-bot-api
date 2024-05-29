<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#polloption
 */
final readonly class PollOption
{
    /**
     * @param string $text
     * @param MessageEntity[]|null $textEntities
     * @param int $voterCount
     */
    public function __construct(
        public string $text,
        public ?array $textEntities,
        public int $voterCount,
    ) {
    }
}

<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#textquote
 */
final readonly class TextQuote
{
    /**
     * @param MessageEntity[]|null $entities
     */
    public function __construct(
        public string $text,
        public ?array $entities,
        public int $position,
        public ?true $isManual,
    ) {
    }
}

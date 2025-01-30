<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ArrayOfObjectsValue;

/**
 * @see https://core.telegram.org/bots/api#textquote
 *
 * @api
 */
final readonly class TextQuote
{
    /**
     * @param MessageEntity[]|null $entities
     */
    public function __construct(
        public string $text,
        public int $position,
        #[ArrayOfObjectsValue(MessageEntity::class)]
        public ?array $entities = null,
        public ?true $isManual = null,
    ) {}
}

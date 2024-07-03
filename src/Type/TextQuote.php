<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

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
        public int $position,
        public ?array $entities = null,
        public ?true $isManual = null,
    ) {
    }

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            ValueHelper::getString($result, 'text', $raw),
            ValueHelper::getInteger($result, 'position', $raw),
            ValueHelper::getArrayOfMessageEntitiesOrNull($result, 'entities', $raw),
            ValueHelper::getTrueOrNull($result, 'is_manual', $raw),
        );
    }
}

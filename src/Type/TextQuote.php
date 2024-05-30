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
        public ?array $entities,
        public int $position,
        public ?true $isManual,
    ) {
    }

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            ValueHelper::getString($result, 'text'),
            ValueHelper::getArrayOfMessageEntitiesOrNull($result, 'entities'),
            ValueHelper::getInteger($result, 'position'),
            ValueHelper::getTrueOrNull($result, 'is_manual'),
        );
    }
}

<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#polloption
 */
final readonly class PollOption
{
    /**
     * @param string $text
     * @param int $voterCount
     * @param MessageEntity[]|null $textEntities
     */
    public function __construct(
        public string $text,
        public int $voterCount,
        public ?array $textEntities = null,
    ) {
    }

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            ValueHelper::getString($result, 'text', $raw),
            ValueHelper::getInteger($result, 'voter_count', $raw),
            ValueHelper::getArrayOfMessageEntitiesOrNull($result, 'text_entities', $raw),
        );
    }
}

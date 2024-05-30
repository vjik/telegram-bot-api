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
     * @param MessageEntity[]|null $textEntities
     * @param int $voterCount
     */
    public function __construct(
        public string $text,
        public ?array $textEntities,
        public int $voterCount,
    ) {
    }

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            ValueHelper::getString($result, 'text'),
            ValueHelper::getArrayOfMessageEntitiesOrNull($result, 'text_entities'),
            ValueHelper::getInteger($result, 'voter_count'),
        );
    }
}

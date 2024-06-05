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

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            ValueHelper::getString($result, 'text'),
            ValueHelper::getInteger($result, 'voter_count'),
            ValueHelper::getArrayOfMessageEntitiesOrNull($result, 'text_entities'),
        );
    }
}

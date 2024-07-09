<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ArrayOfObjectsValue;

/**
 * @see https://core.telegram.org/bots/api#polloption
 */
final readonly class PollOption
{
    /**
     * @param MessageEntity[]|null $textEntities
     */
    public function __construct(
        public string $text,
        public int $voterCount,
        #[ArrayOfObjectsValue(MessageEntity::class)]
        public ?array $textEntities = null,
    ) {}
}

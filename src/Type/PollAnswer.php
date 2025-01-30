<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ArrayMap;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\IntegerValue;

/**
 * @see https://core.telegram.org/bots/api#pollanswer
 *
 * @api
 */
final readonly class PollAnswer
{
    /**
     * @param int[] $optionIds
     */
    public function __construct(
        public string $pollId,
        #[ArrayMap(IntegerValue::class)]
        public array $optionIds,
        public ?Chat $voterChat = null,
        public ?User $user = null,
    ) {}
}

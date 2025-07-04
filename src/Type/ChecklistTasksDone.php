<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ArrayMap;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\IntegerValue;

/**
 * @see https://core.telegram.org/bots/api#checklisttasksdone
 *
 * @api
 */
final readonly class ChecklistTasksDone
{
    /**
     * @param int[]|null $markedAsDoneTaskIds
     * @param int[]|null $markedAsNotDoneTaskIds
     */
    public function __construct(
        public ?Message $checklistMessage = null,
        #[ArrayMap(IntegerValue::class)]
        public ?array $markedAsDoneTaskIds = null,
        #[ArrayMap(IntegerValue::class)]
        public ?array $markedAsNotDoneTaskIds = null,
    ) {}
}

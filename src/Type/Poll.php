<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#poll
 */
final readonly class Poll
{
    /**
     * @param MessageEntity[] $questionEntities
     * @param PollOption[] $options
     * @param MessageEntity[] $explanationEntities
     */
    public function __construct(
        public string $id,
        public string $question,
        public ?array $questionEntities,
        public array $options,
        public int $totalVoterCount,
        public bool $isClosed,
        public bool $isAnonymous,
        public string $type,
        public bool $allowsMultipleAnswers,
        public ?int $correctOptionId,
        public ?string $explanation,
        public ?array $explanationEntities,
        public ?int $openPeriod,
        public ?int $closeDate,
    ) {
    }

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            ValueHelper::getString($result, 'id'),
            ValueHelper::getString($result, 'question'),
            ValueHelper::getArrayOfMessageEntitiesOrNull($result, 'question_entities'),
            array_map(
                static fn ($option) => PollOption::fromTelegramResult($option),
                ValueHelper::getArray($result, 'options')
            ),
            ValueHelper::getInteger($result, 'total_voter_count'),
            ValueHelper::getBoolean($result, 'is_closed'),
            ValueHelper::getBoolean($result, 'is_anonymous'),
            ValueHelper::getString($result, 'type'),
            ValueHelper::getBoolean($result, 'allows_multiple_answers'),
            ValueHelper::getIntegerOrNull($result, 'correct_option_id'),
            ValueHelper::getStringOrNull($result, 'explanation'),
            ValueHelper::getArrayOfMessageEntitiesOrNull($result, 'explanation_entities'),
            ValueHelper::getIntegerOrNull($result, 'open_period'),
            ValueHelper::getIntegerOrNull($result, 'close_date'),
        );
    }
}

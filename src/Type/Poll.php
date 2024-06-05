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
     * @param MessageEntity[]|null $questionEntities
     * @param PollOption[] $options
     * @param MessageEntity[]|null $explanationEntities
     */
    public function __construct(
        public string $id,
        public string $question,
        public array $options,
        public int $totalVoterCount,
        public bool $isClosed,
        public bool $isAnonymous,
        public string $type,
        public bool $allowsMultipleAnswers,
        public ?array $questionEntities = null,
        public ?int $correctOptionId = null,
        public ?string $explanation = null,
        public ?array $explanationEntities = null,
        public ?int $openPeriod = null,
        public ?int $closeDate = null,
    ) {
    }

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            ValueHelper::getString($result, 'id'),
            ValueHelper::getString($result, 'question'),
            array_map(
                static fn ($option) => PollOption::fromTelegramResult($option),
                ValueHelper::getArray($result, 'options')
            ),
            ValueHelper::getInteger($result, 'total_voter_count'),
            ValueHelper::getBoolean($result, 'is_closed'),
            ValueHelper::getBoolean($result, 'is_anonymous'),
            ValueHelper::getString($result, 'type'),
            ValueHelper::getBoolean($result, 'allows_multiple_answers'),
            ValueHelper::getArrayOfMessageEntitiesOrNull($result, 'question_entities'),
            ValueHelper::getIntegerOrNull($result, 'correct_option_id'),
            ValueHelper::getStringOrNull($result, 'explanation'),
            ValueHelper::getArrayOfMessageEntitiesOrNull($result, 'explanation_entities'),
            ValueHelper::getIntegerOrNull($result, 'open_period'),
            ValueHelper::getIntegerOrNull($result, 'close_date'),
        );
    }
}

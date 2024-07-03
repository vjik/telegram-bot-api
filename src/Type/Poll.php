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

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            ValueHelper::getString($result, 'id', $raw),
            ValueHelper::getString($result, 'question', $raw),
            array_map(
                static fn ($option) => PollOption::fromTelegramResult($option, $raw),
                ValueHelper::getArray($result, 'options', $raw)
            ),
            ValueHelper::getInteger($result, 'total_voter_count', $raw),
            ValueHelper::getBoolean($result, 'is_closed', $raw),
            ValueHelper::getBoolean($result, 'is_anonymous', $raw),
            ValueHelper::getString($result, 'type', $raw),
            ValueHelper::getBoolean($result, 'allows_multiple_answers', $raw),
            ValueHelper::getArrayOfMessageEntitiesOrNull($result, 'question_entities', $raw),
            ValueHelper::getIntegerOrNull($result, 'correct_option_id', $raw),
            ValueHelper::getStringOrNull($result, 'explanation', $raw),
            ValueHelper::getArrayOfMessageEntitiesOrNull($result, 'explanation_entities', $raw),
            ValueHelper::getIntegerOrNull($result, 'open_period', $raw),
            ValueHelper::getIntegerOrNull($result, 'close_date', $raw),
        );
    }
}

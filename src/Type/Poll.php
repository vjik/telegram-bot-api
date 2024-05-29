<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

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
}

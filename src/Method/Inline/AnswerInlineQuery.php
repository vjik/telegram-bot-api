<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method\Inline;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\TrueValue;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\TelegramRequestWithResultPreparingInterface;
use Vjik\TelegramBot\Api\Type\Inline\InlineQueryResult;
use Vjik\TelegramBot\Api\Type\Inline\InlineQueryResultsButton;

/**
 * @see https://core.telegram.org/bots/api#answerinlinequery
 *
 * @template-implements TelegramRequestWithResultPreparingInterface<TrueValue>
 */
final readonly class AnswerInlineQuery implements TelegramRequestWithResultPreparingInterface
{
    /**
     * @param InlineQueryResult[] $results
     */
    public function __construct(
        private string $inlineQueryId,
        private array $results,
        private ?int $cacheTime = null,
        private ?bool $isPersonal = null,
        private ?string $nextOffset = null,
        private ?InlineQueryResultsButton $button = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'answerInlineQuery';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'inline_query_id' => $this->inlineQueryId,
                'results' => array_map(
                    static fn(InlineQueryResult $result) => $result->toRequestArray(),
                    $this->results,
                ),
                'cache_time' => $this->cacheTime,
                'is_personal' => $this->isPersonal,
                'next_offset' => $this->nextOffset,
                'button' => $this->button?->toRequestArray(),
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}

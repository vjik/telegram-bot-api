<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method\Inline;

use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\TelegramRequestWithResultPreparingInterface;
use Vjik\TelegramBot\Api\Type\Inline\InlineQueryResult;
use Vjik\TelegramBot\Api\Type\Inline\SentWebAppMessage;

/**
 * @see https://core.telegram.org/bots/api#answerwebappquery
 *
 * @template-implements TelegramRequestWithResultPreparingInterface<class-string<SentWebAppMessage>>
 */
final readonly class AnswerWebAppQuery implements TelegramRequestWithResultPreparingInterface
{
    public function __construct(
        private string $webAppQueryId,
        private InlineQueryResult $result,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'answerWebAppQuery';
    }

    public function getData(): array
    {
        return [
            'web_app_query_id' => $this->webAppQueryId,
            'result' => $this->result->toRequestArray(),
        ];
    }

    public function getResultType(): string
    {
        return SentWebAppMessage::class;
    }
}

<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method\Payment;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\TrueValue;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\TelegramRequestWithResultPreparingInterface;

/**
 * @see https://core.telegram.org/bots/api#answerprecheckoutquery
 *
 * @template-implements TelegramRequestWithResultPreparingInterface<TrueValue>
 */
final readonly class AnswerPreCheckoutQuery implements TelegramRequestWithResultPreparingInterface
{
    public function __construct(
        private string $preCheckoutQueryId,
        private bool $ok,
        private ?string $errorMessage = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'answerPreCheckoutQuery';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'pre_checkout_query_id' => $this->preCheckoutQueryId,
                'ok' => $this->ok,
                'error_message' => $this->errorMessage,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}

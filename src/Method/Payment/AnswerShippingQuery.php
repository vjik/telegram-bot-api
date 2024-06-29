<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method\Payment;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\TelegramRequestWithResultPreparingInterface;
use Vjik\TelegramBot\Api\Type\Payment\ShippingOption;

/**
 * @see https://core.telegram.org/bots/api#answershippingquery
 */
final readonly class AnswerShippingQuery implements TelegramRequestWithResultPreparingInterface
{
    /**
     * @param ShippingOption[]|null $shippingOptions
     */
    public function __construct(
        private string $shippingQueryId,
        private bool $ok,
        private ?array $shippingOptions = null,
        private ?string $errorMessage = null,
    ) {
    }

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'answerShippingQuery';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'shipping_query_id' => $this->shippingQueryId,
                'ok' => $this->ok,
                'shipping_options' => $this->shippingOptions === null ? null : array_map(
                    static fn(ShippingOption $option) => $option->toRequestArray(),
                    $this->shippingOptions,
                ),
                'error_message' => $this->errorMessage,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function prepareResult(mixed $result): true
    {
        ValueHelper::assertTrueResult($result);
        return $result;
    }
}

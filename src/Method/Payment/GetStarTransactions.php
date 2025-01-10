<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Method\Payment;

use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\TelegramRequestWithResultPreparingInterface;
use Vjik\TelegramBot\Api\Type\Payment\StarTransactions;

/**
 * @see https://core.telegram.org/bots/api#getstartransactions
 *
 * @template-implements TelegramRequestWithResultPreparingInterface<class-string<StarTransactions>>
 */
final readonly class GetStarTransactions implements TelegramRequestWithResultPreparingInterface
{
    public function __construct(
        private ?int $offset = null,
        private ?int $limit = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function getApiMethod(): string
    {
        return 'getStarTransactions';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'offset' => $this->offset,
                'limit' => $this->limit,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): string
    {
        return StarTransactions::class;
    }
}

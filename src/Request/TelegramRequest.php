<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Request;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ValueProcessorInterface;

/**
 * @template T as class-string|ValueProcessorInterface|null
 * @template-implements TelegramRequestWithResultPreparingInterface<T>
 */
final readonly class TelegramRequest implements TelegramRequestWithResultPreparingInterface
{
    /**
     * @psalm-param array<string,mixed> $data
     * @psalm-param T $resultType
     */
    public function __construct(
        private HttpMethod $httpMethod,
        private string $apiMethod,
        private array $data = [],
        private string|ValueProcessorInterface|null $resultType = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return $this->httpMethod;
    }

    public function getApiMethod(): string
    {
        return $this->apiMethod;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getResultType(): string|ValueProcessorInterface|null
    {
        return $this->resultType;
    }
}

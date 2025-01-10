<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ValueProcessorInterface;
use Vjik\TelegramBot\Api\Transport\HttpMethod;

/**
 * @template T as class-string|ValueProcessorInterface|null
 * @template-implements MethodInterface<T>
 */
final readonly class CustomMethod implements MethodInterface
{
    /**
     * @psalm-param array<string,mixed> $data
     * @psalm-param T $resultType
     */
    public function __construct(
        private string $apiMethod,
        private array $data = [],
        private string|ValueProcessorInterface|null $resultType = null,
        private HttpMethod $httpMethod = HttpMethod::POST,
    ) {}

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

    public function getHttpMethod(): HttpMethod
    {
        return $this->httpMethod;
    }
}

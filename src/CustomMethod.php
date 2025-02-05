<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api;

use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\RawValue;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ValueProcessorInterface;
use Vjik\TelegramBot\Api\Transport\HttpMethod;

/**
 * @template TResult
 * @template-implements MethodInterface<TResult>
 *
 * @api
 */
final readonly class CustomMethod implements MethodInterface
{
    /**
     * @psalm-param array<string, mixed> $data
     * @psalm-param ValueProcessorInterface<TResult> $resultType
     */
    public function __construct(
        private string $apiMethod,
        private array $data = [],
        private ValueProcessorInterface $resultType = new RawValue(),
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

    public function getResultType(): ValueProcessorInterface
    {
        return $this->resultType;
    }

    public function getHttpMethod(): HttpMethod
    {
        return $this->httpMethod;
    }
}

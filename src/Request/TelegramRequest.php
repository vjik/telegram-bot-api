<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Request;

final readonly class TelegramRequest implements TelegramRequestInterface
{
    /**
     * @var callable|null
     */
    private mixed $successCallback;

    public function __construct(
        private HttpMethod $httpMethod,
        private string $apiMethod,
        private array $data = [],
        ?callable $successCallback = null,
    ) {
        $this->successCallback = $successCallback;
    }

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

    public function getSuccessCallback(): ?callable
    {
        return $this->successCallback;
    }
}

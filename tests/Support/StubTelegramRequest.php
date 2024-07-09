<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Support;

use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Request\TelegramRequestInterface;

final readonly class StubTelegramRequest implements TelegramRequestInterface
{
    public function __construct(
        private HttpMethod $httpMethod = HttpMethod::GET,
        private string $apiMethod = 'getMe',
        private array $data = [],
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
}

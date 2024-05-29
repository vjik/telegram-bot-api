<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Client\Request;

final class TelegramRequest implements TelegramRequestInterface
{
    public function __construct(
        private string $method,
        private array $data = [],
    ) {
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getData(): array
    {
        return $this->data;
    }
}

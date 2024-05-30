<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Client;

final readonly class ApiUrlGenerator
{
    public function __construct(
        private string $token,
        private string $baseUrl,
    ) {
    }

    public function generate(string $method): string
    {
        return $this->baseUrl . '/bot' . $this->token . '/' . $method;
    }
}

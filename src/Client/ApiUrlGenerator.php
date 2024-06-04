<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Client;

/**
 * @see https://core.telegram.org/bots/api#making-requests
 */
final readonly class ApiUrlGenerator
{
    private string $baseUrl;

    public function __construct(
        string $token,
        string $url,
    ) {
        $this->baseUrl = $url . '/bot' . $token . '/';
    }

    public function generate(string $method, array $queryParameters = []): string
    {
        $result = $this->baseUrl . $method;
        if (!empty($queryParameters)) {
            $result .= '?' . http_build_query($queryParameters);
        }
        return $result;
    }
}

<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Transport;

/**
 * @api
 */
interface TransportInterface
{
    /**
     * @psalm-param array<string, mixed> $data
     */
    public function send(
        string $apiMethod,
        array $data = [],
        HttpMethod $httpMethod = HttpMethod::POST,
    ): ApiResponse;
}

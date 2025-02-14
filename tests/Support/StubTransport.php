<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Support;

use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Transport\TransportInterface;
use Vjik\TelegramBot\Api\Transport\ApiResponse;

final readonly class StubTransport implements TransportInterface
{
    public function __construct(
        private ?ApiResponse $response = null,
    ) {}

    public function send(
        string $urlPath,
        array $data = [],
        HttpMethod $httpMethod = HttpMethod::POST,
    ): ApiResponse {
        return $this->response ?? new ApiResponse(200, '');
    }
}

<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Support;

use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Transport\TransportInterface;
use Vjik\TelegramBot\Api\Transport\TelegramResponse;

final class StubTransport implements TransportInterface
{
    public function __construct(
        private ?TelegramResponse $response = null,
    ) {}

    public function send(
        string $apiMethod,
        array $data = [],
        HttpMethod $httpMethod = HttpMethod::POST,
    ): TelegramResponse {
        return $this->response ?? new TelegramResponse(200, '');
    }
}

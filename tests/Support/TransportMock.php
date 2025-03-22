<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Support;

use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Transport\TransportInterface;
use Vjik\TelegramBot\Api\Transport\ApiResponse;

final class TransportMock implements TransportInterface
{
    private ?string $urlPath = null;

    public function __construct(
        private readonly ?ApiResponse $response = null,
    ) {}

    public function send(
        string $urlPath,
        array $data = [],
        HttpMethod $httpMethod = HttpMethod::POST,
    ): ApiResponse {
        $this->urlPath = $urlPath;
        return $this->response ?? new ApiResponse(200, '{"ok":true,"result":true}');
    }

    public function downloadFile(string $url): string
    {
        return '';
    }

    public function downloadFileTo(string $url, string $savePath): void
    {
        // do nothing
    }

    public function urlPath(): ?string
    {
        return $this->urlPath;
    }
}

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
        string $urlPath,
        array $data = [],
        HttpMethod $httpMethod = HttpMethod::POST,
    ): ApiResponse;

    /**
     * @throws DownloadException
     */
    public function download(string $url): string;

    /**
     * @throws DownloadException
     * @throws SaveException
     */
    public function downloadTo(string $url, string $savePath): void;
}

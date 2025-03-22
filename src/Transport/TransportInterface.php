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
     * @throws DownloadFileException
     */
    public function downloadFile(string $url): string;

    /**
     * @throws DownloadFileException
     * @throws SaveFileException
     */
    public function downloadFileTo(string $url, string $savePath): void;
}

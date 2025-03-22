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
     * Downloads a file by URL.
     *
     * @param string $url The URL of the file to download.
     *
     * @return string The file content.
     *
     * @throws DownloadFileException If an error occurred while downloading the file.
     */
    public function downloadFile(string $url): string;

    /**
     * Downloads a file by URL and saves it to a file.
     *
     * @param string $url The URL of the file to download.
     * @param string $savePath The path to save the file.
     *
     * @throws DownloadFileException If an error occurred while downloading the file.
     * @throws SaveFileException If an error occurred while saving the file.
     */
    public function downloadFileTo(string $url, string $savePath): void;
}

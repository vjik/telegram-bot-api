<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Downloader;

use Vjik\TelegramBot\Api\Curl\Curl;
use Vjik\TelegramBot\Api\Curl\CurlException;
use Vjik\TelegramBot\Api\Curl\CurlInterface;

/**
 * @api
 */
final readonly class CurlDownloader implements DownloaderInterface
{
    public function __construct(
        private CurlInterface $curl = new Curl(),
    ) {
    }

    public function download(string $url, ?string $filePath = null): string
    {
        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FAILONERROR => true,
        ];

        try {
            $curl = $this->curl->init();
        } catch (CurlException $exception) {
            throw new DownloadException($exception->getMessage(), previous: $exception);
        }

        try {
            $this->curl->setopt_array($curl, $options);

            /**
             * @var string $result `curl_exec` returns string because `CURLOPT_RETURNTRANSFER` is set to `true`.
             */
            $result = $this->curl->exec($curl);
        } catch (CurlException $exception) {
            throw new DownloadException($exception->getMessage(), previous: $exception);
        } finally {
            $this->curl->close($curl);
        }

        return $result;
    }

    public function downloadTo(string $url, string $savePath): void
    {
        $fileHandler = @fopen($savePath, 'wb');
        if ($fileHandler === false) {
            $lastError = error_get_last();
            throw new SaveException($lastError['message'] ?? 'Failed to open local file for writing.');
        }

        $options = [
            CURLOPT_URL => $url,
            CURLOPT_FILE => $fileHandler,
            CURLOPT_FAILONERROR => true,
        ];

        try {
            $curl = $this->curl->init();
        } catch (CurlException $exception) {
            throw new DownloadException($exception->getMessage(), previous: $exception);
        }

        try {
            $this->curl->setopt_array($curl, $options);
            $this->curl->exec($curl);
        } catch (CurlException $exception) {
            throw new DownloadException($exception->getMessage(), previous: $exception);
        } finally {
            $this->curl->close($curl);
        }
    }
}

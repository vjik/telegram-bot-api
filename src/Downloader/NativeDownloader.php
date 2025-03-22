<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Downloader;

/**
 * @see https://www.php.net/manual/function.file-get-contents.php
 *
 * @api
 */
final readonly class NativeDownloader implements DownloaderInterface
{
    public function download(string $url): string
    {
        $result = @file_get_contents($url);
        if ($result === false) {
            $lastError = error_get_last();
            throw new DownloadException($lastError['message'] ?? 'Unknown download error.');
        }

        return $result;
    }

    public function downloadTo(string $url, string $savePath): void
    {
        $content = $this->download($url);

        $result = @file_put_contents($savePath, $content);
        if ($result === false) {
            $lastError = error_get_last();
            throw new SaveException($lastError['message'] ?? 'Unknown save error.');
        }
    }
}

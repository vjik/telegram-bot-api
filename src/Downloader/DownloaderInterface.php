<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Downloader;

/**
 * @api
 */
interface DownloaderInterface
{
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

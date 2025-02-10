<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Transport\Curl;

use CurlHandle;
use RuntimeException;

use function curl_close;
use function curl_errno;
use function curl_error;
use function curl_exec;
use function curl_getinfo;
use function curl_init;
use function curl_setopt_array;

/**
 * @internal
 */
final class Curl implements CurlInterface
{
    public function close(CurlHandle $handle): void
    {
        curl_close($handle);
    }

    public function exec(CurlHandle $handle): ?string
    {
        $result = curl_exec($handle);
        if ($result === false) {
            throw new RuntimeException(
                'CURL error: ' . curl_error($handle),
                curl_errno($handle),
            );
        }

        return $result === true ? null : $result;
    }

    public function getinfo(CurlHandle $handle, ?int $option = null): mixed
    {
        return curl_getinfo($handle, $option);
    }

    public function init(): CurlHandle
    {
        $result = curl_init();
        if ($result === false) {
            throw new RuntimeException('Failed to initialize CURL.');
        }

        return $result;
    }

    public function setopt_array(CurlHandle $handle, array $options): void
    {
        $result = curl_setopt_array($handle, $options);
        if ($result === false) {
            throw new RuntimeException('Failed to set CURL options.');
        }
    }
}

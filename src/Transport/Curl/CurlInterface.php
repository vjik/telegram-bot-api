<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Transport\Curl;

use CurlHandle;

/**
 * @internal
 */
interface CurlInterface
{
    public function close(CurlHandle $handle): void;

    public function exec(CurlHandle $handle): ?string;

    public function getinfo(CurlHandle $handle, ?int $option = null): mixed;

    public function init(): CurlHandle;

    public function setopt_array(CurlHandle $handle, array $options): void;
}

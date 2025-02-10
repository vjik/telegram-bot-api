<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Transport\CurlTransport;

use CurlHandle;
use Vjik\TelegramBot\Api\Transport\Curl\CurlInterface;

use function curl_init;

final class CurlMock implements CurlInterface
{
    public function __construct(
        private ?string $execResult = null,
        private array $getinfoResult = [],
    ) {}

    public function close(CurlHandle $handle): void {}

    public function exec(CurlHandle $handle): ?string
    {
        return $this->execResult;
    }

    public function getinfo(CurlHandle $handle, ?int $option = null): mixed
    {
        return $option === null ? $this->getinfoResult : ($this->getinfoResult[$option] ?? null);
    }

    public function init(): CurlHandle
    {
        return curl_init();
    }

    public function setopt_array(CurlHandle $handle, array $options): void {}
}

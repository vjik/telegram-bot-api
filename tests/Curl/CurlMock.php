<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Curl;

use CurlHandle;
use Throwable;
use Vjik\TelegramBot\Api\Curl\CurlInterface;

use function curl_init;

final class CurlMock implements CurlInterface
{
    private ?array $options = null;
    private int $countCallOfClose = 0;

    public function __construct(
        private readonly string|Throwable $execResult = '',
        private readonly array $getinfoResult = [],
        private readonly ?Throwable $initException = null,
    ) {}

    public function close(CurlHandle $handle): void
    {
        $this->countCallOfClose++;
    }

    public function exec(CurlHandle $handle): string
    {
        if ($this->execResult instanceof Throwable) {
            throw $this->execResult;
        }

        return $this->execResult;
    }

    public function getinfo(CurlHandle $handle, ?int $option = null): mixed
    {
        return $option === null ? $this->getinfoResult : ($this->getinfoResult[$option] ?? null);
    }

    public function init(): CurlHandle
    {
        if ($this->initException !== null) {
            throw $this->initException;
        }
        return curl_init();
    }

    public function setopt_array(CurlHandle $handle, array $options): void
    {
        $this->options = $options;
    }

    public function getOptions(): ?array
    {
        return $this->options;
    }

    public function getCountCallOfClose(): int
    {
        return $this->countCallOfClose;
    }
}

<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Transport\PsrTransport\StrictTypeRequest;

use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;

final class StrictTypeRequestFactory implements RequestFactoryInterface
{
    public function createRequest(string $method, $uri): RequestInterface
    {
        return new StrictTypeRequest($method, $uri);
    }
}
